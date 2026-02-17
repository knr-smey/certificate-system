<?php $uri = $_SERVER['REQUEST_URI']; ?>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-content">
            <i class="bi bi-award-fill sidebar-logo-icon"></i>
            <span>ប្រព័ន្ធសញ្ញាបត្រ</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <!-- Dashboard -->
        <div class="nav-item">
            <a class="nav-link <?= str_contains($uri, 'dashboard') ? 'active' : '' ?>"
               href="<?= base_url('dashboard') ?>">
                <i class="bi bi-speedometer2 nav-icon"></i>
                <span>ផ្ទាំងគ្រប់គ្រង</span>
            </a>
        </div>

        <!-- Certificates Dropdown -->
        <div class="nav-item nav-dropdown">
            <a class="nav-link dropdown-toggle"
               data-bs-toggle="collapse"
               href="#certMenu"
               aria-expanded="true">
                <span class="d-flex align-items-center gap-2">
                    <i class="bi bi-patch-check nav-icon"></i>
                    <span>សញ្ញាបត្រ</span>
                </span>
                <i class="bi bi-chevron-down chevron"></i>
            </a>

            <div class="collapse show nav-submenu" id="certMenu">
                <a class="nav-link <?= str_contains($uri, 'type=normal') ? 'active' : '' ?>"
                   href="<?= base_url('certificate?type=normal') ?>">
                    <i class="bi bi-file-earmark-text nav-icon"></i>
                    <span>សញ្ញាបត្រធម្មតា</span>
                </a>
                <a class="nav-link <?= str_contains($uri, 'type=free') ? 'active' : '' ?>"
                   href="<?= base_url('certificate?type=free') ?>">
                    <i class="bi bi-gift nav-icon"></i>
                    <span>សញ្ញាបត្រឥតគិតថ្លៃ</span>
                </a>
                <a class="nav-link <?= str_contains($uri, 'type=scholarship') ? 'active' : '' ?>"
                   href="<?= base_url('certificate?type=scholarship') ?>">
                    <i class="bi bi-mortarboard nav-icon"></i>
                    <span>សញ្ញាបត្រអាហារូបករណ៍</span>
                </a>
            </div>
        </div>

        <!-- Teachers -->
        <div class="nav-item">
            <a class="nav-link <?= str_contains($uri, 'teacher') ? 'active' : '' ?>"
               href="<?= base_url('teacher') ?>">
                <i class="bi bi-person-badge nav-icon"></i>
                <span>គ្រូបង្រៀន</span>
            </a>
        </div>
    </nav>
</aside>
