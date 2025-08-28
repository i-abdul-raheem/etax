<?php
// SQLite3 configuration for eTax consultants Pakistan
// Use this file instead of config.php if you prefer SQLite3

// Database configuration
define('DB_TYPE', 'sqlite');
define('DB_FILE', __DIR__ . '/../database/taxpulse.db');

// Site configuration
define('SITE_NAME', 'eTax consultants Pakistan');
define('SITE_URL', 'http://localhost:8000');
define('SITE_EMAIL', 'info@taxpulse-pakistan.com');
define('SITE_PHONE', '+92 21 3582 1757');

// Blog configuration
define('POSTS_PER_PAGE', 6);
define('ADMIN_EMAIL', 'admin@taxpulse-pakistan.com');

// Security
define('HASH_COST', 12);
define('SESSION_TIMEOUT', 3600); // 1 hour

// Error reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Asia/Karachi');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE && !headers_sent()) {
    session_start();
}
?>
