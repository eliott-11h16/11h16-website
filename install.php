<?php
require_once __DIR__ . '/includes/config.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (strlen($username) < 3 || strlen($password) < 6) {
        $error = 'Username (min 3 chars) and password (min 6 chars) required.';
    } else {
        try {
            $pdo = new PDO('mysql:host=' . DB_HOST, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);

            // Create database
            $pdo->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
            $pdo->exec('USE `' . DB_NAME . '`');

            // Create tables
            $pdo->exec('
                CREATE TABLE IF NOT EXISTS admin_users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(50) NOT NULL UNIQUE,
                    password_hash VARCHAR(255) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB
            ');

            $pdo->exec('
                CREATE TABLE IF NOT EXISTS projects (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    slug VARCHAR(100) NOT NULL UNIQUE,
                    name VARCHAR(150) NOT NULL,
                    title_html VARCHAR(255) NOT NULL,
                    client VARCHAR(100) NOT NULL,
                    type VARCHAR(100) NOT NULL,
                    year SMALLINT NOT NULL,
                    thumbnail VARCHAR(255) NOT NULL DEFAULT "",
                    is_wide TINYINT(1) DEFAULT 0,
                    display_order INT DEFAULT 0,
                    is_hero TINYINT(1) DEFAULT 0,
                    hero_video VARCHAR(255) DEFAULT NULL,
                    preview_video VARCHAR(255) DEFAULT NULL,
                    show_on_site TINYINT(1) DEFAULT 0,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) ENGINE=InnoDB
            ');

            $pdo->exec('
                CREATE TABLE IF NOT EXISTS project_media (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    project_id INT NOT NULL,
                    type ENUM("image", "video") NOT NULL,
                    file_path VARCHAR(255) NOT NULL,
                    alt_text VARCHAR(255) DEFAULT "",
                    layout ENUM("full", "grid-2", "grid-3", "grid-1") DEFAULT "grid-2",
                    grid_group INT DEFAULT 0,
                    display_order INT DEFAULT 0,
                    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
                ) ENGINE=InnoDB
            ');

            $pdo->exec('
                CREATE TABLE IF NOT EXISTS site_content (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    section_key VARCHAR(50) NOT NULL UNIQUE,
                    content TEXT NOT NULL,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) ENGINE=InnoDB
            ');

            // Create admin user
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT IGNORE INTO admin_users (username, password_hash) VALUES (?, ?)');
            $stmt->execute([$username, $hash]);

            $message = 'Installation complete! <a href="admin/">Go to admin panel</a>. Delete this file (install.php) now.';
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install — 11H16 CMS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; background: #f5f5f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .card { background: #fff; padding: 40px; border-radius: 8px; width: 400px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { font-size: 24px; margin-bottom: 8px; }
        p.sub { color: #888; margin-bottom: 24px; font-size: 14px; }
        label { display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 6px; }
        input { width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; margin-bottom: 16px; }
        button { width: 100%; padding: 12px; background: #000; color: #fff; border: none; border-radius: 4px; font-size: 14px; font-weight: 600; cursor: pointer; }
        button:hover { background: #333; }
        .msg { padding: 12px; border-radius: 4px; margin-bottom: 16px; font-size: 14px; }
        .msg a { color: #000; font-weight: 600; }
        .msg.ok { background: #e8f5e9; color: #2e7d32; }
        .msg.err { background: #fbe9e7; color: #c62828; }
    </style>
</head>
<body>
    <div class="card">
        <h1>11H16 CMS Setup</h1>
        <p class="sub">Create database tables and admin account</p>
        <?php if ($message): ?><div class="msg ok"><?= $message ?></div><?php endif; ?>
        <?php if ($error): ?><div class="msg err"><?= e($error) ?></div><?php endif; ?>
        <form method="POST">
            <label>Admin Username</label>
            <input type="text" name="username" required minlength="3">
            <label>Admin Password</label>
            <input type="password" name="password" required minlength="6">
            <button type="submit">Install</button>
        </form>
    </div>
</body>
</html>
