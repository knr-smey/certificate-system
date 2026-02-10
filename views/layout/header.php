<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?= $title ?? 'App' ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


<style>
.sidebar{width:260px;min-height:100vh}
.menu-link{display:flex;gap:8px;padding:10px;border-radius:6px;text-decoration:none;color:#333}
.menu-link:hover{background:#f1f5f9}
.active{background:#e0e7ff;font-weight:bold}
</style>
</head>

<body>
<div class="d-flex">
<?php require __DIR__.'/sidebar.php'; ?>
<main class="flex-grow-1 p-4">
