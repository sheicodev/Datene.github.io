<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['credential'];

    $client_id = "543114283027-77gg78k07a522qfi7ta6sfkk49rfg64g.apps.googleusercontent.com";

    $url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . $token;
    $response = file_get_contents($url);
    $userData = json_decode($response, true);

    if ($userData && isset($userData['email'])) {
        // Encode dữ liệu gửi về cửa sổ gốc nếu cần
        $name = htmlspecialchars($userData['name']);
        $email = htmlspecialchars($userData['email']);
        $picture = htmlspecialchars($userData['picture']);

        // Gửi dữ liệu về cửa sổ cha và chuyển hướng
        echo "<script>
            window.opener.postMessage({
                name: '$name',
                email: '$email',
                picture: '$picture'
            }, '*');
            window.close();
        </script>";
    } else {
        echo "Đăng nhập thất bại.";
    }
} else {
    echo "Không có dữ liệu.";
}
?>
