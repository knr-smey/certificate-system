<?php
    $message = $_SESSION['form_message'] ?? '';
    $errors  = $errors ?? [];
    $old     = $old ?? [];
    $certificates = $certificates ?? [];
    unset($_SESSION['form_message']);
?>

<!-- Include Form Component -->
<?php include 'views/components/forms/form_class_free.php'; ?>

<!-- Include Table Component -->
<?php include 'views/components/tables/table_class_free.php'; ?>
