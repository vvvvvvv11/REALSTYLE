<?php
require_once '../config.php';
requireLogin();

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'error' => 'Missing id']);
    exit;
}

// Get image path to delete file
$gallery = supabaseGet('gallery', ['id' => 'eq.' . $id]);
if (!empty($gallery) && isset($gallery[0]['image_url'])) {
    $filePath = '../' . $gallery[0]['image_url'];
    if (file_exists($filePath)) unlink($filePath);
}

$result = supabaseDelete('gallery?id=eq.' . $id);
echo json_encode(['success' => $result['success']]);
?>
