<?php
declare(strict_types=1);

function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function base_url(string $path = ''): string {
    // Works for InfinityFree subfolder too
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    $dir = rtrim(str_replace('\\','/', dirname($script)), '/');
    $base = ($dir === '' ? '/' : $dir . '/');
    return $base . ltrim($path, '/');
}
