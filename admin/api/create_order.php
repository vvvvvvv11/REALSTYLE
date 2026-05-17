<?php
require_once '../config.php';

$data = json_decode(file_get_contents('php://input'), true);
$link = $data['link'] ?? '';
$price_cny = $data['price_cny'] ?? 0;
$size = $data['size'] ?? '';
$comment = $data['comment'] ?? '';
$amount = $data['amount'] ?? 0;
$orderNumber = 'RS' . time();

if (!$link || !$price_cny) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

$result = supabasePost('orders', [
    'order_number' => $orderNumber,
    'title' => 'Новый заказ',
    'link' => $link,
    'price_cny' => $price_cny,
    'size' => $size,
    'comment' => $comment,
    'amount' => $amount,
    'status' => 'new'
]);

echo json_encode(['success' => $result['success']]);
?>
