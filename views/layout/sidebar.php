<?php $uri = $_SERVER['REQUEST_URI']; ?>

<div class="sidebar">
  
  <div class="logo">
    <div class="logo-content">
      <i class="bi bi-award-fill logo-icon"></i>
      <span>ប្រព័ន្ធវិញ្ញាបនបត្រ</span>
    </div>
  </div>

  <ul class="list-unstyled sidebar-nav">

    <!-- Dashboard -->
    <li class="nav-item">
      <a class="link <?= str_contains($uri,'dashboard') ? 'kh-active' : '' ?>"
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
         aria-expanded="true">
        <span class="d-flex align-items-center gap-2">
          <i class="bi bi-patch-check icon"></i>
          <span>វិញ្ញាបនបត្រ</span>
        </span>
        <i class="bi bi-chevron-down chevron"></i>
      </a>

      <div class="collapse show sub" id="certMenu">
        <a class="link <?= str_contains($uri,'type=normal') ? 'kh-active' : '' ?>"
           href="<?= base_url('certificate?type=normal') ?>">
          <i class="bi bi-file-earmark-text icon"></i>
          <span>វិញ្ញាបនបត្រធម្មតា</span>
        </a>
        <a class="link <?= str_contains($uri,'type=free') ? 'kh-active' : '' ?>"
           href="<?= base_url('certificate?type=free') ?>">
          <i class="bi bi-gift icon"></i>
          <span>វិញ្ញាបនបត្រឥតគិតថ្លៃ</span>
        </a>
        <a class="link <?= str_contains($uri,'type=scholarship') ? 'kh-active' : '' ?>"
           href="<?= base_url('certificate?type=scholarship') ?>">
          <i class="bi bi-mortarboard icon"></i>
          <span>វិញ្ញាបនបត្រអាហារូបករណ៍</span>
        </a>
      </div>
    </li>

    <!-- Teachers -->
    <li class="nav-item">
      <a class="link <?= str_contains($uri,'teacher') ? 'kh-active' : '' ?>"
         href="<?= base_url('teacher') ?>">
        <i class="bi bi-person-badge icon"></i>
        <span>គ្រូបង្រៀន</span>
      </a>
    </li>

  </ul>
</div>
