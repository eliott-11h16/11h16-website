<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';

if (!isset($_SESSION['admin_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);
$layout = $_POST['layout'] ?? 'grid-2';
$gridGroup = (int)($_POST['grid_group'] ?? 0);
$altText = $_POST['alt_text'] ?? '';

if ($id) {
    updateMedia($id, ['layout' => $layout, 'grid_group' => $gridGroup, 'alt_text' => $altText]);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'No ID']);
}
