<?php
require_once '../config.php';
requireLogin();

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'error' => 'Missing id']);
    exit;
}

$result = supabaseDelete('faq?id=eq.' . $id);
echo json_encode(['success' => $result['success']]);
?>
