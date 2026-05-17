<?php
require_once '../config.php';

$orders = supabaseGet('orders');
$pendingOrders = supabaseGet('orders', ['status' => 'neq.completed', 'status' => 'neq.cancelled']);
$completedOrders = supabaseGet('orders', ['status' => 'eq.completed']);
$gallery = supabaseGet('gallery');

$totalRevenue = 0;
foreach ($completedOrders as $order) {
    $totalRevenue += $order['amount'] ?? 0;
}

echo json_encode([
    'success' => true,
    'total_orders' => count($orders),
    'pending_orders' => count($pendingOrders),
    'total_revenue' => $totalRevenue,
    'gallery_count' => count($gallery)
]);
?>
