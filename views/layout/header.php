
<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Certificate System' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/sidebar.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/dashboard.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/studentslist.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/teacherlist.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/class-free-form.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/table-class-free.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/table-class-scholarship.css')?>" rel="stylesheet" >

</head>
<body>
    <div class="d-flex font-siemreap">
        <?php require __DIR__ . '/sidebar.php'; ?>
        <main class="flex-grow-1 p-4">