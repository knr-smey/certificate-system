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
  
  <div class="logo">
    <div class="logo-content">
      <i class="bi bi-award-fill logo-icon"></i>
      <span>ប្រព័ន្ធសញ្ញាបត្រ</span>
    </div>
  </div>

  <ul class="list-unstyled sidebar-nav">

    <!-- Dashboard -->
    <li class="nav-item">
      <a class="link <?= $isDashboard ? 'kh-active' : '' ?>"
         href="<?= base_url('dashboard') ?>">
        <i class="bi bi-speedometer2 icon"></i>
        <span>ផ្ទាំងគ្រប់គ្រង</span>
      </a>
    </li>

    <!-- Certificates -->
    <li class="nav-item">
      <a class="link collapse-toggle justify-content-between"
         data-bs-toggle="collapse"
         href="#certMenu"
         aria-expanded="<?= $isCertSection ? 'true' : 'false' ?>">
        <span class="d-flex align-items-center gap-2">
          <i class="bi bi-patch-check icon"></i>
          <span>សញ្ញាបត្រ</span>
        </span>
        <i class="bi bi-chevron-down chevron"></i>
      </a>

      <div class="collapse <?= $isCertSection ? 'show' : '' ?> sub" id="certMenu">
        <a class="link <?= $isNormal ? 'kh-active' : '' ?>"
           href="<?= base_url('certificate?type=normal') ?>">
          <i class="bi bi-file-earmark-text icon"></i>
          <span>សញ្ញាបត្រធម្មតា</span>
        </a>
        <a class="link <?= $isFree ? 'kh-active' : '' ?>"
           href="<?= base_url('certificate?type=free') ?>">
          <i class="bi bi-gift icon"></i>
          <span>សញ្ញាបត្រឥតគិតថ្លៃ</span>
        </a>
        <a class="link <?= $isScholarship ? 'kh-active' : '' ?>"
           href="<?= base_url('certificate?type=scholarship') ?>">
          <i class="bi bi-mortarboard icon"></i>
          <span>សញ្ញាបត្រអាហារូបករណ៍</span>
        </a>
      </div>
    </li>

    <!-- Teachers -->
    <li class="nav-item">
      <a class="link <?= $isTeacher ? 'kh-active' : '' ?>"
         href="<?= base_url('teacher') ?>">
        <i class="bi bi-person-badge icon"></i>
        <span>គ្រូបង្រៀន</span>
      </a>
    </li>

  </ul>
</div>