<?php
require_once '../config.php';

$result = supabaseGet('faq', ['order' => 'sort_order.asc']);
echo json_encode(['success' => true, 'faq' => $result]);
?>
