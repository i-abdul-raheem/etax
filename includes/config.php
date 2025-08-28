<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'taxpulse_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site configuration
define('SITE_NAME', 'eTax consultants Pakistan');
define('SITE_URL', 'http://localhost/taxpulse');
define('SITE_EMAIL', 'info@etaxconsultants.org');
define('SITE_PHONE', '+92 21 3582 1757');

// Blog configuration
define('POSTS_PER_PAGE', 6);
define('ADMIN_EMAIL', 'admin@etaxconsultants.org');

// Security
define('HASH_COST', 12);
define('SESSION_TIMEOUT', 3600); // 1 hour

// Error reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Asia/Karachi');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
