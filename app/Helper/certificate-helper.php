<?php


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
function generateCertificateId() {
    $year = date('Y'); // current year
    $random4 = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT); // 4 digit random
    return $year . $random4 . 'ETEC';
}

/**
 * Generate a unique certificate ID (shorthand)
 */
function generateId() {
    return generateCertificateId();
}
