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
if ($id) {
    deleteMedia($id);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'No ID']);
}
