<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $_SESSION['name'] = $data['name'];
    $_SESSION['email'] = $data['email'];
    $_SESSION['picture'] = $data['picture'];
}
?>