<?php
// Đưa key trực tiếp ở đây
header('Content-Type: application/json; charset=utf-8');

/* Cho phép gọi từ JS cùng origin. Nếu cần nhiều domain thêm origin cụ thể */
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit; }

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(["status" => "API OK", "message" => "Use POST with 'text'"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
    exit;
}
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['OPENAI_API_KEY'];



$userMessage = $_POST['text'] ?? '';
if (trim($userMessage) === '') {
    echo json_encode(["error" => "No message provided"]);
    exit;
}
$currentBio = $_POST['bio'] ?? '';
$currentInterests = $_POST['interests'] ?? '';

$systemPrompt = "Bạn là cô gái dễ thương trong ứng dụng hẹn hò Datene. 
Người mà bạn đang nhập vai có sở thích: $currentInterests. 
Bio của cô ấy: $currentBio. 
Bạn nên dùng biểu tượng cảm xúc, trả lời ngắn gọn, tự nhiên và hơi lả lơi nếu phù hợp.";

$payload = [
    "model" => "gpt-4o-mini",
    "messages" => [
        ["role" => "system", "content" => $systemPrompt],
        ["role" => "user", "content" => $userMessage]
    ]
];

if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [];
}
$_SESSION['chat_history'][] = ["role" => "user", "content" => $userMessage];

// Giới hạn số dòng giữ lại để tránh quá tải
$_SESSION['chat_history'] = array_slice($_SESSION['chat_history'], -10);

// Tạo prompt đầy đủ
$messages = array_merge([
    ["role" => "system", "content" => $systemPrompt]
], $_SESSION['chat_history']);


$ch = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($ch);
if ($response === false) {
    http_response_code(500);
    echo json_encode(["error" => "cURL error: " . curl_error($ch)]);
    curl_close($ch);
    exit;
}
curl_close($ch);

echo $response;