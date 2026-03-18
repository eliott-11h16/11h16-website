<?php require_once 'auth.php';

$id = (int)($_GET['id'] ?? 0);
if ($id) {
    deleteProject($id);
}
header('Location: index.php?msg=deleted');
exit;
