<?php
declare(strict_types=1);

// Basic error reporting (dev). On production you can lower this.
ini_set('display_errors', '1');
error_reporting(E_ALL);

// Autoload (tiny PSR-4 style)
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) return;

    $relative = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relative) . '.php';
    if (is_file($file)) require $file;
});

// Config
require __DIR__ . '/config.php';

// Start session if you later need it
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helpers (optional)
require __DIR__ . '/helpers.php';
