<?php
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['email'])) {
    $_SESSION['email'] = $data['email'];
    $_SESSION['name'] = $data['name'] ?? '';
    $_SESSION['picture'] = $data['picture'] ?? '';
    http_response_code(200);
    echo json_encode(['status' => 'success']);
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ']);
}
