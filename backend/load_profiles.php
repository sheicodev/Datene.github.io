<?php
$pdo = new PDO("mysql:host=localhost;dbname=datene_database", "root", ""); // chỉnh thông tin kết nối

$stmt = $pdo->query("SELECT * FROM users");
$users = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $interests = explode(",", $row['interests']); // tách thành mảng
    $users[] = [
        'name' => $row['name'],
        'image' => $row['image_url'],
        'interests' => $interests
    ];
}

header('Content-Type: application/json');
echo json_encode($users);
?>