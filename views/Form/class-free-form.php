<?php
    $message = $message ?? '';
    $errors  = $errors ?? [];
    $old     = $old ?? [];
    $certificates = $certificates ?? [];
    $showCertificate = $showCertificate ?? false;
    $certificateData = $certificateData ?? null;
    $generatedId = $generatedId ?? '';
    unset($_SESSION['form_message']);
    
    // Get display data - use submitted data if available, otherwise use old input or defaults
    $displayName = $certificateData['student_name'] ?? $old['student_name'] ?? '';
    $displayCourse = $certificateData['course'] ?? $old['course'] ?? '';
    $displayId = $certificateData['id'] ?? '';
    
    // Get certificate granted date using helper function
    // Logic: If current day <= cutoff day (10), go back to previous month
    // Otherwise use current month. Then use certificate day (15) or days in month (whichever is smaller)
    // Example: If today is Feb 28, 2026 (day > 10), result is Feb 15, 2026
    // Example: If today is Feb 5, 2026 (day <= 10), result is Jan 15, 2026
    // Use user-selected end_date if available (from DB or form), otherwise use current date
    $baseDate = $certificateData['end_date'] ?? $old['end_date'] ?? null;
    $certDateObj = getCertificateDate(10, 15, 'Asia/Phnom_Penh', true, $baseDate);
    $displayDate = $certDateObj->format('F j, Y');
?>

<!-- Include Form Component -->
<?php include 'views/components/forms/form_class_free.php'; ?>

<!-- Include Certificate Component -->
<?php include 'views/components/certificate/class-free-certificate.php'; ?>


