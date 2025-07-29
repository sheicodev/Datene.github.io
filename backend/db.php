<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host    = $_ENV['DB_HOST'];
$db      = $_ENV['DB_NAME'];
$user    = $_ENV['DB_USER'];
$pass    = $_ENV['DB_PASS'];
$port    = $_ENV['DB_PORT'];
$charset = $_ENV['DB_CHARSET'];

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo "❌ Kết nối database thất bại: " . $e->getMessage();
}
?>
