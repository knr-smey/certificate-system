<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'App' ?></title>

    <!-- link cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- link css -->
    <link href="./assets/css/app.css" rel="stylesheet">
    <link href="./assets/css/sidebar.css" rel="stylesheet">
    <link href="./assets/css/dashboard.css" rel="stylesheet">
</head>
<body>
<div class="d-flex font-siemreap">
    <!-- sidebar -->
    <?php require __DIR__.'/sidebar.php'; ?>

    <!-- main content -->
    <main class="flex-grow-1 p-4">
