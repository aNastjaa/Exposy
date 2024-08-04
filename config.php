<?php

error_reporting(E_ALL);
ini_set("display_errors","1");

// project directory paths
define('PUBLIC_DIR', __DIR__ . DIRECTORY_SEPARATOR . 'public');
define('TEMPLATES_DIR', __DIR__ . DIRECTORY_SEPARATOR . 'templates');
define('UPLOAD_PATH', PUBLIC_DIR . DIRECTORY_SEPARATOR . 'uploads');

// database configuration
define('DB_HOST', '127.0.0.1');
define('DB_CHARSET', 'utf8mb4');
define('DB_PORT', '3306');
define('DB_NAME', 'exposy');
define('DB_USER', 'root');
define('DB_PASS', '');