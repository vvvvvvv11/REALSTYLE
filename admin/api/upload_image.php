<?php
require_once '../config.php';
requireLogin();

$uploadDir = '../uploads/';
if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = time() . '_' . uniqid() . '.' . $ext;
    $filepath = $uploadDir . $filename;
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $filepath)) {
        $imageUrl = '/admin/uploads/' . $filename;
        $title = $_POST['title'] ?? '';
        $subtitle = $_POST['subtitle'] ?? '';
        $link = $_POST['link'] ?? '';
        
        $result = supabasePost('gallery', [
            'title' => $title,
            'subtitle' => $subtitle,
            'image_url' => $imageUrl,
            'link' => $link,
            'sort_order' => time()
        ]);
        
        echo json_encode(['success' => $result['success']]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to move file']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No file uploaded']);
}
?>
