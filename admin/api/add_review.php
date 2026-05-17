<?php
require_once '../config.php';
requireLogin();

$data = json_decode(file_get_contents('php://input'), true);
$author = $data['author'] ?? '';
$rating = $data['rating'] ?? 5;
$text = $data['text'] ?? '';

if (!$author || !$text) {
    echo json_encode(['success' => false, 'error' => 'Missing data']);
    exit;
}

$result = supabasePost('reviews', [
    'author' => $author,
    'rating' => (int)$rating,
    'text' => $text
]);

echo json_encode(['success' => $result['success']]);
?>
