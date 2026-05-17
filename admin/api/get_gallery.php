<?php
require_once '../config.php';

$result = supabaseGet('gallery', ['order' => 'sort_order.asc']);
echo json_encode(['success' => true, 'items' => $result]);
?>
