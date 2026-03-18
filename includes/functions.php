<?php
require_once __DIR__ . '/db.php';

// ─── Projects ─────────────────────────────────

function getAllProjects() {
    return getDB()->query('SELECT * FROM projects WHERE show_on_site = 1 ORDER BY display_order ASC')->fetchAll();
}

function getAllProjectsAdmin() {
    return getDB()->query('SELECT * FROM projects ORDER BY display_order ASC')->fetchAll();
}

function getProjectBySlug($slug) {
    $stmt = getDB()->prepare('SELECT * FROM projects WHERE slug = ?');
    $stmt->execute([$slug]);
    return $stmt->fetch();
}

function getProjectById($id) {
    $stmt = getDB()->prepare('SELECT * FROM projects WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getHeroProjects() {
    return getDB()->query('SELECT * FROM projects WHERE is_hero = 1 ORDER BY display_order ASC')->fetchAll();
}

function getAdjacentProjects($currentOrder) {
    $db = getDB();

    $stmt = $db->prepare('SELECT slug, name FROM projects WHERE display_order < ? ORDER BY display_order DESC LIMIT 1');
    $stmt->execute([$currentOrder]);
    $prev = $stmt->fetch();

    $stmt = $db->prepare('SELECT slug, name FROM projects WHERE display_order > ? ORDER BY display_order ASC LIMIT 1');
    $stmt->execute([$currentOrder]);
    $next = $stmt->fetch();

    // Wrap around
    if (!$prev) {
        $prev = $db->query('SELECT slug, name FROM projects ORDER BY display_order DESC LIMIT 1')->fetch();
    }
    if (!$next) {
        $next = $db->query('SELECT slug, name FROM projects ORDER BY display_order ASC LIMIT 1')->fetch();
    }

    return ['prev' => $prev, 'next' => $next];
}

function saveProject($data, $id = null) {
    $db = getDB();
    if ($id) {
        $stmt = $db->prepare('UPDATE projects SET slug=?, name=?, title_html=?, client=?, type=?, year=?, thumbnail=?, is_wide=?, is_hero=?, hero_video=?, preview_video=?, show_on_site=? WHERE id=?');
        $stmt->execute([$data['slug'], $data['name'], $data['title_html'], $data['client'], $data['type'], $data['year'], $data['thumbnail'], $data['is_wide'], $data['is_hero'], $data['hero_video'], $data['preview_video'] ?? null, $data['show_on_site'] ?? 0, $id]);
        return $id;
    } else {
        $maxOrder = $db->query('SELECT COALESCE(MAX(display_order), 0) FROM projects')->fetchColumn();
        $stmt = $db->prepare('INSERT INTO projects (slug, name, title_html, client, type, year, thumbnail, is_wide, is_hero, hero_video, preview_video, show_on_site, display_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$data['slug'], $data['name'], $data['title_html'], $data['client'], $data['type'], $data['year'], $data['thumbnail'], $data['is_wide'], $data['is_hero'], $data['hero_video'], $data['preview_video'] ?? null, $data['show_on_site'] ?? 0, $maxOrder + 1]);
        return $db->lastInsertId();
    }
}

function deleteProject($id) {
    $db = getDB();
    // Get media files to delete
    $media = getProjectMedia($id);
    foreach ($media as $m) {
        $path = __DIR__ . '/../' . $m['file_path'];
        if (file_exists($path)) unlink($path);
    }
    // Delete thumbnail
    $project = getProjectById($id);
    if ($project && $project['thumbnail']) {
        $path = __DIR__ . '/../' . $project['thumbnail'];
        if (file_exists($path)) unlink($path);
    }
    if ($project && $project['hero_video']) {
        $path = __DIR__ . '/../' . $project['hero_video'];
        if (file_exists($path)) unlink($path);
    }
    $db->prepare('DELETE FROM projects WHERE id = ?')->execute([$id]);
}

function toggleShowOnSite($id) {
    $db = getDB();
    $db->prepare('UPDATE projects SET show_on_site = NOT show_on_site WHERE id = ?')->execute([$id]);
}

function reorderProjects($ids) {
    $db = getDB();
    $stmt = $db->prepare('UPDATE projects SET display_order = ? WHERE id = ?');
    foreach ($ids as $order => $id) {
        $stmt->execute([$order, $id]);
    }
}

// ─── Media ────────────────────────────────────

function getProjectMedia($projectId) {
    $stmt = getDB()->prepare('SELECT * FROM project_media WHERE project_id = ? ORDER BY grid_group ASC, display_order ASC');
    $stmt->execute([$projectId]);
    return $stmt->fetchAll();
}

function getGroupedMedia($projectId) {
    $media = getProjectMedia($projectId);
    $groups = [];
    foreach ($media as $m) {
        $groups[$m['grid_group']][] = $m;
    }
    return $groups;
}

function addMedia($projectId, $filePath, $type, $layout = 'grid-2', $gridGroup = 0) {
    $db = getDB();
    $maxOrder = $db->prepare('SELECT COALESCE(MAX(display_order), 0) FROM project_media WHERE project_id = ?');
    $maxOrder->execute([$projectId]);
    $order = $maxOrder->fetchColumn() + 1;

    $stmt = $db->prepare('INSERT INTO project_media (project_id, type, file_path, layout, grid_group, display_order) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$projectId, $type, $filePath, $layout, $gridGroup, $order]);
    return $db->lastInsertId();
}

function updateMedia($id, $data) {
    $stmt = getDB()->prepare('UPDATE project_media SET layout=?, grid_group=?, alt_text=? WHERE id=?');
    $stmt->execute([$data['layout'], $data['grid_group'], $data['alt_text'], $id]);
}

function deleteMedia($id) {
    $db = getDB();
    $stmt = $db->prepare('SELECT file_path FROM project_media WHERE id = ?');
    $stmt->execute([$id]);
    $media = $stmt->fetch();
    if ($media) {
        $path = __DIR__ . '/../' . $media['file_path'];
        if (file_exists($path)) unlink($path);
    }
    $db->prepare('DELETE FROM project_media WHERE id = ?')->execute([$id]);
}

// ─── Site Content ─────────────────────────────

function getSiteContent($key) {
    $stmt = getDB()->prepare('SELECT content FROM site_content WHERE section_key = ?');
    $stmt->execute([$key]);
    $row = $stmt->fetch();
    return $row ? $row['content'] : '';
}

function getAllSiteContent() {
    $rows = getDB()->query('SELECT section_key, content FROM site_content')->fetchAll();
    $content = [];
    foreach ($rows as $row) {
        $content[$row['section_key']] = $row['content'];
    }
    return $content;
}

function setSiteContent($key, $value) {
    $db = getDB();
    $stmt = $db->prepare('INSERT INTO site_content (section_key, content) VALUES (?, ?) ON DUPLICATE KEY UPDATE content = ?');
    $stmt->execute([$key, $value, $value]);
}

// ─── Helpers ──────────────────────────────────

function generateSlug($name) {
    $slug = strtolower($name);
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    $slug = preg_replace('/[\s-]+/', '-', $slug);
    return trim($slug, '-');
}

function uploadFile($file, $prefix = '') {
    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'mp4', 'mov'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) return false;
    if ($file['size'] > MAX_UPLOAD_SIZE) return false;
    if ($file['error'] !== UPLOAD_ERR_OK) return false;

    $filename = ($prefix ? $prefix . '_' : '') . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $dest = UPLOAD_DIR . $filename;

    if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0755, true);
    if (move_uploaded_file($file['tmp_name'], $dest)) {
        return UPLOAD_URL . $filename;
    }
    return false;
}

function isVideo($path) {
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    return in_array($ext, ['mp4', 'mov', 'webm']);
}

function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function csrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrf() {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        die('Invalid CSRF token');
    }
}
