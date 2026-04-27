<?php
use App\Core\Database;

function getCertificateDate($cutoffDay = 10, $certificateDay = 15, $timezone = 'Asia/Phnom_Penh', $returnObject = false, $baseDate = null)
{
    // Set the timezone
    date_default_timezone_set($timezone);
    
    // Use provided date or current date
    if ($baseDate !== null) {
        if ($baseDate instanceof DateTime) {
            $today = clone $baseDate;
        } else {
            $today = new DateTime($baseDate);
        }
    } else {
        $today = new DateTime();
    }
    
    $currentDay = (int)$today->format('d');
    
    // If current day is <= cutoff day, go back to previous month
    if ($currentDay <= $cutoffDay) {
        $today->modify('-1 month');
    }
    
    $year = (int)$today->format('Y');
    $month = (int)$today->format('m');
    
    // Get the number of days in the target month
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    
    // Use the minimum of certificateDay and daysInMonth (for months with fewer days)
    $finalDay = min($certificateDay, $daysInMonth);
    
    // Create the final date
    $finalDate = new DateTime();
    $finalDate->setDate($year, $month, $finalDay);
    
    if ($returnObject) {
        return $finalDate;
    }
    
    return $finalDate->format('d.m.Y');
}


function printCertificateDate($format = 'd.m.Y', $baseDate = null)
{
    $certificateDate = getCertificateDate(10, 15, 'Asia/Phnom_Penh', true, $baseDate);
    return $certificateDate->format($format);
}

/**
 * Generate a unique certificate ID
 * Format: 10-digit number + ' ETEC' (e.g., "1234567890 ETEC")
 */
function generateCertificateId()
{
    $pdo = Database::pdo();

    $yearMonth = date('ym'); // YYMM

    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM certificate_class_free
        WHERE DATE_FORMAT(created_at,'%y%m') = ?
    ");

    $stmt->execute([$yearMonth]);

    $count = (int)$stmt->fetchColumn() + 1;

    $sequence = str_pad($count, 3, '0', STR_PAD_LEFT);

    return $yearMonth . $sequence . ' ETEC';
}

/**
 * Generate a unique certificate ID (shorthand)
 */
function generateId(){
    return generateCertificateId();
}

function generateCertificateNormalId()
{
    $pdo = Database::pdo();

    $yearMonth = date('ym'); // YYMM

    $stmt = $pdo->prepare("
        SELECT certificate_id
        FROM student_certificate_normal
        WHERE certificate_id IS NOT NULL
          AND certificate_id <> ''
          AND certificate_id LIKE ?
        ORDER BY id DESC
        LIMIT 1
    ");

    $stmt->execute([$yearMonth . '%']);
    $lastId = (string)$stmt->fetchColumn();

    $nextSequence = 1;

    if ($lastId !== '' && preg_match('/^(\d{4})(\d{3,})\s*ETEC$/i', trim($lastId), $matches)) {
        $lastPrefix = $matches[1];
        $lastSequence = (int)$matches[2];

        if ($lastPrefix === $yearMonth) {
            $nextSequence = $lastSequence + 1;
        }
    }

    return $yearMonth . str_pad((string)$nextSequence, 3, '0', STR_PAD_LEFT) . ' ETEC';
}

function generateNormal(){
    return generateCertificateNormalId();
}
