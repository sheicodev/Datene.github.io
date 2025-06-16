<?php
session_start(); // <-- Bắt đầu session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/';
    $profileDir = 'profiles/';
    if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
    if (!file_exists($profileDir)) mkdir($profileDir, 0777, true);

    function uploadImage($file, $prefix = 'img') {
        global $uploadDir;
        if ($file['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid($prefix . '_', true) . '.' . $ext;
            $destination = $uploadDir . $filename;
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return $destination;
            }
        }
        return null;
    }

    function uploadGallery($files) {
        $paths = [];
        foreach ($files['name'] as $i => $name) {
            $file = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i]
            ];
            $path = uploadImage($file, 'gallery');
            if ($path) $paths[] = $path;
        }
        return $paths;
    }

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $birth_month = $_POST['birth_month'] ?? '';
    $birth_day = $_POST['birth_day'] ?? '';
    $birth_year = $_POST['birth_year'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $interest = $_POST['interest'] ?? '';
    $relationship = $_POST['relationship'] ?? '';

    $avatarPath = null;
    $galleryPaths = [];

    if (!empty($_FILES['gallery']) && is_array($_FILES['gallery']['name'])) {
        $galleryPaths = uploadGallery($_FILES['gallery']);
        $avatarPath = $galleryPaths[0] ?? null;
    }

    $data = [
        'name' => $name,
        'email' => $email,
        'birthdate' => "$birth_year-$birth_month-$birth_day",
        'gender' => $gender,
        'interest' => $interest,
        'relationship' => $relationship,
        'avatar' => $avatarPath,
        'gallery' => $galleryPaths,
    ];

    // 🔐 Lưu vào SESSION để dùng sau
    $_SESSION['user_profile'] = $data;

    // 📝 Lưu vào file JSON để backup (tùy chọn)
    $filename = $profileDir . 'profile_' . time() . '.json';
    file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));

    // ✅ Phản hồi
    echo "<h2>✅ Profile saved successfully!</h2>";
    echo "<a href='profile_view.php'>View Profile</a><br><br>";
    echo "<pre>" . print_r($data, true) . "</pre>";
} else {
    echo "<h3>⛔ Invalid request method.</h3>";
}
 header("Location: home.php");
    exit;
?>
