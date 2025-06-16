<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $_SESSION['theme'] = $data['theme'] ?? 'light';
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    exit;
}