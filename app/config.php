<?php
declare(strict_types=1);

// XAMPP MySQL defaults
defined('DB_HOST')    || define('DB_HOST', '127.0.0.1'); // localhost also works
defined('DB_NAME')    || define('DB_NAME', 'your_database_name'); // create in phpMyAdmin
defined('DB_USER')    || define('DB_USER', 'root'); // default XAMPP user
defined('DB_PORT')    || define('DB_PORT', '3306'); // default MySQL port
defined('DB_PASS')    || define('DB_PASS', ''); // default is empty
defined('DB_CHARSET') || define('DB_CHARSET', 'utf8mb4');
