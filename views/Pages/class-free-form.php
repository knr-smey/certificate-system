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
    

    $baseDate = $certificateData['end_date'] ?? $old['end_date'] ?? null;
    $certDateObj = getCertificateDate(10, 15, 'Asia/Phnom_Penh', true, $baseDate);
    $displayDate = $certDateObj->format('F j, Y');
?>

<!-- Include Form Component -->
<?php include 'views/components/forms/form_class_free.php'; ?>

<!-- Include Certificate Component -->
<?php include 'views/components/certificate/class-free-certificate.php'; ?>


