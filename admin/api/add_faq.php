<?php
require_once '../config.php';
requireLogin();

$data = json_decode(file_get_contents('php://input'), true);
$question = $data['question'] ?? '';
$answer = $data['answer'] ?? '';

if (!$question || !$answer) {
    echo json_encode(['success' => false, 'error' => 'Missing data']);
    exit;
}

$result = supabasePost('faq', [
    'question' => $question,
    'answer' => $answer,
    'sort_order' => time()
]);

echo json_encode(['success' => $result['success']]);
?>
