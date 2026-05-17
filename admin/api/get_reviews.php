<?php
require_once '../config.php';

$result = supabaseGet('reviews', ['order' => 'created_at.desc']);
echo json_encode(['success' => true, 'reviews' => $result]);
?>
