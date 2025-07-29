<?php
require 'db.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$likedId = (int)$data['user_id'];

$stmt = $pdo->prepare("DELETE FROM likes WHERE liker_id = ? AND liked_id = ?");
$success = $stmt->execute([$_SESSION['user_id'], $likedId]);

echo json_encode(['success' => $success]);
