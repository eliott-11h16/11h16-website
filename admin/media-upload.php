<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';

if (!isset($_SESSION['admin_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

header('Content-Type: application/json');

$projectId = (int)($_POST['project_id'] ?? 0);
if (!$projectId) {
    echo json_encode(['error' => 'No project ID']);
    exit;
}

$project = getProjectById($projectId);
if (!$project) {
    echo json_encode(['error' => 'Project not found']);
    exit;
}

$results = [];

if (!empty($_FILES['files'])) {
    $files = $_FILES['files'];
    $count = is_array($files['name']) ? count($files['name']) : 1;

    for ($i = 0; $i < $count; $i++) {
        $file = [
            'name' => is_array($files['name']) ? $files['name'][$i] : $files['name'],
            'tmp_name' => is_array($files['tmp_name']) ? $files['tmp_name'][$i] : $files['tmp_name'],
            'size' => is_array($files['size']) ? $files['size'][$i] : $files['size'],
            'error' => is_array($files['error']) ? $files['error'][$i] : $files['error'],
        ];

        $path = uploadFile($file, $project['slug']);
        if ($path) {
            $type = isVideo($path) ? 'video' : 'image';
            $mediaId = addMedia($projectId, $path, $type);
            $results[] = ['id' => $mediaId, 'path' => $path, 'type' => $type];
        }
    }
}

echo json_encode(['success' => true, 'media' => $results]);
