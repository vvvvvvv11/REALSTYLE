<?php
require_once '../config.php';
requireLogin();

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;
$status = $data['status'] ?? null;

if (!$id || !$status) {
    echo json_encode(['success' => false, 'error' => 'Missing data']);
    exit;
}

$result = supabasePatch('orders?id=eq.' . $id, ['status' => $status]);
echo json_encode(['success' => $result['success']]);
?>
