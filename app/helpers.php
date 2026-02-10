<?php
declare(strict_types=1);

function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function base_url(string $path = ''): string {
    $script = $_SERVER['SCRIPT_NAME'];   // /project/public/index.php
    $base = str_replace('/index.php', '', $script);
    return $base . '/' . ltrim($path, '/');
}

