<?php
$host = '127.0.0.1';     // hoặc 'localhost'
$db   = 'datene_database'; // tên database của bạn
$user = 'root';
$pass = '';
$port = 3307;            // kiểm tra đúng cổng bạn đang dùng
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Kết nối thành công đến database <strong>$db</strong>!";
} catch (PDOException $e) {
    echo "❌ Lỗi kết nối database: " . $e->getMessage();
}
?>