<?php
declare(strict_types=1);

function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function base_url(string $path = ''): string {
    $script = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
    
    // Remove index.php from the path
    $base = str_replace('/index.php', '', $script);
    
    // Ensure we have at least a root slash
    if (empty($base)) {
        $base = '/';
    } else if (!str_starts_with($base, '/')) {
        $base = '/' . $base;
    }
    
    // Ensure base ends with slash
    if (!str_ends_with($base, '/')) {
        $base = $base . '/';
    }
    
    return $base . ltrim($path, '/');
}

