<?php
session_start();
require __DIR__ . '/db.php'; // Kết nối database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra dữ liệu bắt buộc
    $required = ['name', 'email', 'birth_month', 'birth_day', 'birth_year', 'gender'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            die("Vui lòng điền đầy đủ thông tin bắt buộc");
        }
    }

    // Xử lý dữ liệu cơ bản
    $name = $_POST['name'];
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) die("Email không hợp lệ");

    $birthdate = sprintf("%04d-%02d-%02d",
        $_POST['birth_year'],
        $_POST['birth_month'],
        $_POST['birth_day']
    );

    // Xử lý ảnh đại diện
    $avatarPath = '../images/default.png'; // ảnh mặc định

    if (isset($_FILES['gallery']) && isset($_FILES['gallery']['tmp_name'][0]) && $_FILES['gallery']['error'][0] === 0) {
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileTmp = $_FILES['gallery']['tmp_name'][0];
        $fileName = time() . '_' . basename($_FILES['gallery']['name'][0]);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmp, $targetPath)) {
            $avatarPath = $targetPath;
        }
    }

    try {
        // Thêm người dùng vào database
        $stmt = $pdo->prepare("
            INSERT INTO user (Username, Email, Gender, Avatar, BDay)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $name,
            $email,
            $_POST['gender'],
            $avatarPath, // lưu đường dẫn đầy đủ
            $birthdate
        ]);
        // Lưu user_id vào session
        $_SESSION['user_id'] = $pdo->lastInsertId();

        $_SESSION['user_profile'] = [
            'id' => $_SESSION['user_id'],
            'name' => $name,
            'email' => $email,
            'avatar' => $avatarPath, // đường dẫn đầy đủ để dùng lại
            'gender' => $_POST['gender'],
            'birthdate' => $birthdate
        ];
        

        header("Location: home.php");
        exit;

    } catch (PDOException $e) {
        die("Lỗi database: " . $e->getMessage());
    }
} else {
    header("Location: profile.php");
    exit;
}
