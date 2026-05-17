<?php
require_once '../config.php';
requireLogin();

$result = supabaseGet('orders', ['order' => 'id.desc']);
echo json_encode(['success' => true, 'orders' => $result]);
?>
