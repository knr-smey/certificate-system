<?php $uri = $_SERVER['REQUEST_URI']; ?>

<style>
.sidebar{
  width:260px;
  min-height:100vh;
  background:oklch(28.2% 0.091 267.935); 
}
.logo{
  background:oklch(28.2% 0.091 267.935); 
}
.link{
  display:flex;
  align-items:center;
  gap:10px;
  padding:10px 14px;
  border-radius:8px;
  color:#fff;
  text-decoration:none;
  font-size:15px;
}
.link:hover{
  background:#1d4ed8; 
  color:#fff;
}
.active{
  background:#1e40af;
  font-weight:600;
}
.sub a{
  font-size:14px;
  padding-left:36px;
  opacity:.95;
}
.icon{
  font-size:18px;
  width:22px;
  text-align:center;
}
</style>

<div class="sidebar">

  
  <div class="logo p-3 text-white fw-bold text-center">
    <i class="bi bi-award-fill me-1"></i>
    ប្រព័ន្ធវិញ្ញាបនបត្រ
  </div>

  <ul class="list-unstyled p-3">

    
    <li class="mb-1">
      <a class="link <?= str_contains($uri,'dashboard')?'kh-active':'' ?>"
         href="<?= base_url('dashboard') ?>">
        <i class="bi bi-speedometer2 icon"></i>
        ផ្ទាំងគ្រប់គ្រង
      </a>
    </li>

    
    <li class="mb-1">
      <a class="link justify-content-between"
         data-bs-toggle="collapse"
         href="#certMenu">
        <span>
          <i class="bi bi-patch-check icon"></i>
          វិញ្ញាបនបត្រ
        </span>
        <i class="bi bi-chevron-down"></i>
      </a>

      <div class="collapse show sub" id="certMenu">
        <a class="link <?= str_contains($uri,'type=normal')?'kh-active':'' ?>"
           href="<?= base_url('certificate?type=normal') ?>">
          <i class="bi bi-file-earmark-text kh-icon"></i>
          វិញ្ញាបនបត្រធម្មតា
        </a>
        <a class="link <?= str_contains($uri,'type=free')?'kh-active':'' ?>"
           href="<?= base_url('certificate?type=free') ?>">
          <i class="bi bi-gift icon"></i>
          វិញ្ញាបនបត្រឥតគិតថ្លៃ
        </a>
        <a class="link <?= str_contains($uri,'type=scholarship')?'kh-active':'' ?>"
           href="<?= base_url('certificate?type=scholarship') ?>">
          <i class="bi bi-mortarboard icon"></i>
          វិញ្ញាបនបត្រអាហារូបករណ៍
        </a>
      </div>
    </li>

    
    <li class="mb-1">
      <a class="link <?= str_contains($uri,'teacher')?'kh-active':'' ?>"
         href="<?= base_url('teacher') ?>">
        <i class="bi bi-person-badge icon"></i>
        គ្រូបង្រៀន
      </a>
    </li>

  </ul>
</div>
