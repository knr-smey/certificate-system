<?php $uri = $_SERVER['REQUEST_URI']; ?>

<?php
$path          = parse_url($uri, PHP_URL_PATH);
$isNormal      = str_contains($uri, 'type=normal') || (str_contains($path, 'certificate/students') && !str_contains($uri, 'type=free') && !str_contains($uri, 'type=scholarship'));
$isFree        = str_contains($uri, 'type=free');
$isScholarship = str_contains($uri, 'type=scholarship');
$isCertSection = str_contains($path, 'certificate');
$isTeacher     = str_contains($path, 'teacher');
$isDashboard   = str_contains($path, 'dashboard');
?>

<div class="sidebar">

    <!-- Logo Area -->
    <div class="sidebar-logo">
        <div class="sidebar-logo-content">
            <i class="bi bi-award-fill sidebar-logo-icon"></i>
            <span>ប្រព័ន្ធសញ្ញាបត្រ</span>
        </div>
    </div>

    <!-- Navigation -->
    <ul class="list-unstyled sidebar-nav">

        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link <?= $isDashboard ? 'active' : '' ?>"
               href="<?= base_url('dashboard') ?>">
                <i class="bi bi-speedometer2 nav-icon"></i>
                <span>ផ្ទាំងគ្រប់គ្រង</span>
            </a>
        </li>

        <!-- Certificates -->
        <li class="nav-item nav-dropdown">
            <a class="nav-link dropdown-toggle <?= $isCertSection ? 'active' : 'collapsed' ?>"
               data-bs-toggle="collapse"
               href="#certMenu"
               aria-expanded="<?= $isCertSection ? 'true' : 'false' ?>">
                <span class="d-flex align-items-center gap-2">
                    <i class="bi bi-patch-check nav-icon"></i>
                    <span>សញ្ញាបត្រ</span>
                </span>
                <i class="bi bi-chevron-down chevron"></i>
            </a>

            <div class="collapse <?= $isCertSection ? 'show' : '' ?>" id="certMenu">
                <div class="nav-submenu">
                    <a class="nav-link <?= $isNormal ? 'active' : '' ?>"
                       href="<?= base_url('certificate?type=normal') ?>">
                        <i class="bi bi-file-earmark-text nav-icon"></i>
                        <span>សញ្ញាបត្រធម្មតា</span>
                    </a>
                    <a class="nav-link <?= $isFree ? 'active' : '' ?>"
                       href="<?= base_url('certificate?type=free') ?>">
                        <i class="bi bi-gift nav-icon"></i>
                        <span>សញ្ញាបត្រឥតគិតថ្លៃ</span>
                    </a>
                    <a class="nav-link <?= $isScholarship ? 'active' : '' ?>"
                       href="<?= base_url('certificate?type=scholarship') ?>">
                        <i class="bi bi-mortarboard nav-icon"></i>
                        <span>សញ្ញាបត្រអាហារូបករណ៍</span>
                    </a>
                </div>
            </div>
        </li>

        <!-- Teachers -->
        <li class="nav-item">
            <a class="nav-link <?= $isTeacher ? 'active' : '' ?>"
               href="<?= base_url('teacher') ?>">
                <i class="bi bi-person-badge nav-icon"></i>
                <span>គ្រូបង្រៀន</span>
            </a>
        </li>

    </ul>
</div>