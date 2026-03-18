<?php
// Database configuration — Update with your Hostinger credentials
// Copy this file to config.php and fill in your details
// Hostinger: find these in hPanel > Databases > MySQL Databases
define('DB_HOST', 'localhost');
define('DB_NAME', 'u123456789_11h16');     // Your database name
define('DB_USER', 'u123456789_admin');     // Your database user
define('DB_PASS', 'your_password_here');   // Your database password

// Paths
define('UPLOAD_DIR', __DIR__ . '/../uploads/projects/');
define('UPLOAD_URL', 'uploads/projects/');
define('ASSETS_URL', 'assets/projects/');
define('MAX_UPLOAD_SIZE', 50 * 1024 * 1024); // 50MB

// Site
define('SITE_NAME', '11H16');
