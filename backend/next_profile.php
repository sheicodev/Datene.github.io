<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'db.php';
session_start();

$currentUserId = $_SESSION['current_profile_id'] ?? 1;

$stmt = $pdo->prepare("SELECT u.*, p.Bio, p.Interests 
                       FROM user u 
                       LEFT JOIN profile p ON u.UserID = p.UserID 
                       WHERE u.UserID > ? 
                       ORDER BY u.UserID ASC 
                       LIMIT 1");
$stmt->execute([$currentUserId]);
$nextUser = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$nextUser) {
    $stmt = $pdo->prepare("SELECT u.*, p.Bio, p.Interests 
                           FROM user u 
                           LEFT JOIN profile p ON u.UserID = p.UserID 
                           ORDER BY u.UserID ASC 
                           LIMIT 1");
    $stmt->execute();
    $nextUser = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($nextUser) {
    $_SESSION['current_profile_id'] = $nextUser['UserID'];
    echo json_encode($nextUser);
    exit;
} else {
    echo json_encode(['error' => 'No user found']);
    exit;
}
