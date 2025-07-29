<?php
require_once 'db.php';

// Thêm cột Avatar vào SELECT
$stmt = $pdo->query("SELECT user.UserID, Username, Interests, Avatar FROM user JOIN profile ON user.UserID = profile.UserID");

// Lấy thêm Bio từ profile
$stmt = $pdo->query("SELECT user.UserID, Username, Interests, Avatar, Bio FROM user JOIN profile ON user.UserID = profile.UserID");

$profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Trả về JSON
header('Content-Type: application/json');
echo json_encode($profiles);
?>
