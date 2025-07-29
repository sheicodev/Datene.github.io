<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'db.php';
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$likedUserId = (int)($data['liked_user_id'] ?? 0);

try {
    // Kiểm tra user tồn tại
    $stmt = $pdo->prepare("SELECT UserID FROM user WHERE UserID = ?");
    $stmt->execute([$likedUserId]);
    if (!$stmt->fetch()) {
        echo json_encode(['success' => false, 'error' => 'User not found']);
        exit;
    }

    // Kiểm tra đã like chưa
    $stmt = $pdo->prepare("SELECT * FROM likes WHERE liker_id = ? AND liked_id = ?");
    $stmt->execute([$_SESSION['user_id'], $likedUserId]);
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'error' => 'Already liked']);
        exit;
    }

    // Thực hiện like
    $stmt = $pdo->prepare("INSERT INTO likes (liker_id, liked_id) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $likedUserId]);
    
    echo json_encode(['success' => true, 'message' => 'Liked successfully']);

} catch (PDOException $e) {
    error_log('Like error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
