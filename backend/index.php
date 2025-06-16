<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATENE</title>
    <link rel="stylesheet" href="../asset/index.css">
    <link href="https://fonts.cdnfonts.com/css/shablagoo" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/retro-groove" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/adventrue" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.cdnfonts.com/css/slab-tall-x" rel="stylesheet">
</head>
<body>
    <div id="head">
        <div id="head_inner">
            <p id="web_name"> DATENE </p>
        </div>
        <div id="head_inner">
            </div>
        <div id="head_inner">
            </div>
        <div id="head_inner">
            <div>

            </div>
        </div>
    </div>
    <div id="middle">
        <div id="middle_inner_left">
                <img src="../images/love.PNG" alt="Love Image">
        </div>
        <div id="middle_inner_right">
            <div id="bold_p">
                <p> Find your true love for your own </p>
            </div>
            <div id="light_p">
                <p> Perfect place for people sharing their stories, hobbies and other stuffs </p>
            </div>
            <div class="login">
                <div class="google_login">
                    <a href="" onclick="openLoginWindow()">
                        <i class="fa-brands fa-google"></i>
                        Login by Google
                    </a>
                </div>
                <div class="facebook_login">
                    <a href="">
                        <i class="fa-brands fa-facebook"></i>
                        Login by Facebook
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="middle_2">
        <div id="middle_2_inner_left">
            <div id="bold_p">
                <p> You deserve a love, don't you? </p>
            </div>
            <div id="light_p">
                <p> Everyone has rights for love, so why you just ... in ... </p>
            </div>
        </div>
        <div id="middle_2_inner_right">
            <img src="../images/loving.jpg" alt="Love Image">
        </div>
    </div>
    <div id="middle_3">
        <div id="middle_3_container_left">
                <div id="middle_3_left">
                    
                </div>
                <div id="middle_3_right">
                    <div class="image-container" id="middle_3_right_img1">
                        <img src="../images/girl.webp" alt="Girl">
                        <div class="message-box">
                            🧡 Want a date with me?
                        </div>
                    </div>

                    <div class="image-container" id="middle_3_right_img2">
                        <img src="../images/ryan gostling.jpg" alt="Ryan Gosling">
                        <div class="message-box">
                            💖 Sure i'll be the one?
                    </div>
                </div>
            </div>
        </div>
        <div id="middle_3_inner_right">
            <div id="bold_p">
                <p> You deserve a love, don't you? </p>
            </div>
            <div id="light_p">
                <p> Everyone has rights for love, so why you just ... in ... </p>
            </div>
        </div>
    </div>
</body>
<script>
    function openLoginWindow() {
    window.open(
        "http://localhost/DATENE/backend/login.php",
        "LoginWindow",
        "width=500,height=600,top=100,left=100"
    );
    }

    window.addEventListener("message", function(event) {
    const user = event.data;

    fetch("http://localhost/DATENE/backend/set-session.php", {
        method: "POST",
        headers: {
        "Content-Type": "application/json"
        },
        body: JSON.stringify(user)
    }).then(() => {
        // Sau khi lưu session xong, chuyển hướng
        window.location.href = "http://localhost/DATENE/backend/profile.php";
    });
    });
</script>

</html>

<?php

?>