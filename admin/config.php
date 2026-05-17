<?php
session_start();

// Supabase configuration
define('SUPABASE_URL', 'https://hdowacmcfrglbwvdgbgg.supabase.co');
define('SUPABASE_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imhkb3dhY21jZnJnbGJ3dmRnYmdnIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzkwMTg1MDksImV4cCI6MjA5NDU5NDUwOX0.srlB8miWPqheVX2OKL16DEKaf_QGJ99BxFFG26JztIs');

// Admin credentials (пароль: admin123)
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD_HASH', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

// Supabase API request function
function supabaseRequest($method, $endpoint, $data = null) {
    $url = SUPABASE_URL . '/rest/v1/' . $endpoint;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Content-Type: application/json',
        'Prefer: return=representation'
    ]);
    
    if ($data && ($method === 'POST' || $method === 'PUT' || $method === 'PATCH')) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'success' => $httpCode >= 200 && $httpCode < 300,
        'data' => json_decode($response, true),
        'code' => $httpCode
    ];
}

function supabaseGet($endpoint, $params = []) {
    $url = SUPABASE_URL . '/rest/v1/' . $endpoint;
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

function supabasePost($endpoint, $data) {
    return supabaseRequest('POST', $endpoint, $data);
}

function supabasePut($endpoint, $data) {
    return supabaseRequest('PUT', $endpoint, $data);
}

function supabasePatch($endpoint, $data) {
    return supabaseRequest('PATCH', $endpoint, $data);
}

function supabaseDelete($endpoint) {
    return supabaseRequest('DELETE', $endpoint);
}
?>
