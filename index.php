<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATENE</title>
    <link rel="stylesheet" href="asset/index.css">
    <link href="https://fonts.cdnfonts.com/css/shablagoo" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/retro-groove" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/adventrue" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.cdnfonts.com/css/slab-tall-x" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
</head>
<body>
    <div id="head">
        <div id="head_inner">
            <a href="index.php" class="a_name"><p id="web_name"> DATENE </p></a>
        </div>
        <div id="head_inner">
            </div>
        <div id="head_inner">
            </div>
        <div id="head_inner">
            <div>

            </div>
        </div>
        <div id="particles-js"></div>
    </div>
    <div id="middle" class="section">
        <div id="middle_inner_left">
            <img src="images/love.PNG" alt="Love Image">
        </div>
        <div id="middle_inner_right">
            <div id="bold_p">
                <h4 class="typing-text" data-text="Find your true love for your own 💖"></h4>
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
            </div>
        </div>
    </div>
    <div id="middle_2" class="section">
        <div id="middle_2_inner_left">
            <div id="bold_p">
                <div class="fade-in"> <!-- Áp dụng cho từng ảnh hoặc đoạn giới thiệu --> 
                    <h4 class="typing-text" data-text="You deserve a love, don’t you?"></h4>
                </div>
            </div>
            <div id="light_p">
                <p> “Everyone deserves love. So why not start your story here?” </p>
            </div>
        </div>
        <div id="middle_2_inner_right">
            <img src="images/loving.jpg" alt="Love Image">
        </div>
    </div>
    <div id="middle_3" class="section">
        <div id="middle_3_container_left">
                <div id="middle_3_left">
                    
                </div>
                <div id="middle_3_right">
                    <div class="image-container" id="middle_3_right_img1">
                        <img src="images/girl.webp" alt="Girl">
                        <div class="message-box">
                            🧡 Want a date with me?
                        </div>
                    </div>

                    <div class="image-container" id="middle_3_right_img2">
                        <img src="images/ryan gostling.jpg" alt="Ryan Gosling">
                        <div class="message-box">
                            💖 Sure i'll be the one?
                    </div>
                </div>
            </div>
        </div>
        <div id="middle_3_inner_right">
            <div id="bold_p">
                <h4 class="typing-text" data-text="Find your destiny with us right now 💖"></h4>
            </div>
            <div id="light_p">
                <p> Everyone has rights for love, so why don't you just log in</p>
            </div>
        </div>
    </div>
</body>
<script>
    // tim bay bay
    window.onload = function () {
    // Khởi động particlesJS
        particlesJS("particles-js", {
            particles: {
            number: { value: 10  },
            shape: {
                type: "image",
                image: {
                src: "http://localhost/DATENE/images/heart.png",  // đã đúng
                width: 20,
                height: 20
                }
            },
            size: { value: 25 },
            move: { speed: 2.5 },
            opacity: { value: 0.3 }
            },
            interactivity: {
            events: {
                onhover: { enable: true, mode: "repulse" }
            }
            }
        });
    }
    const typingTimeouts = new Map();
    // Typing Animation
   document.addEventListener("DOMContentLoaded", function () {
        const typingTimeouts = new Map();
        
        function startTyping(element) {
            const text = element.dataset.text;
            element.innerHTML = "";

            if (typingTimeouts.has(element)) {
                clearTimeout(typingTimeouts.get(element));
                typingTimeouts.delete(element);
            }

            let i = 0;
            function type() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    const timeout = setTimeout(type, 60);
                    typingTimeouts.set(element, timeout);
                } else {
                    typingTimeouts.delete(element);
                }
            }

            type();
        }

        const typingElements = document.querySelectorAll(".typing-text");

        const typingObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    startTyping(entry.target);
                }
            });
        }, {
            threshold: 0.6
        });

        typingElements.forEach(el => typingObserver.observe(el));
    });

    //
    function openLoginWindow() {
        window.open(
            "http://localhost/DATENE/backend/login.php",
            "LoginWindow",
            "width=500,height=600,top=100,left=100"
        );
    }

    window.addEventListener("message", function(event) {
    console.log("🔥 Nhận được dữ liệu từ popup:", event.data); // THÊM LOG NÀY
    
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
    const faders = document.querySelectorAll(".fade-in");
    //Fade in
    const appearOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -100px 0px"
    };

    const appearOnScroll = new IntersectionObserver(function(entries, observer) {
    entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add("appear");
        observer.unobserve(entry.target);
    });
    }, appearOptions);

    faders.forEach(fader => {
    appearOnScroll.observe(fader);
    });
    // Fade in/out scroll effect
    const sections = document.querySelectorAll('.section');

        const sectionObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            } else {
                entry.target.classList.remove('visible');
            }
            });
        },
        {
            threshold: 0.4 // phần tử phải xuất hiện 40% trong màn hình mới trigger
        }
        );

        sections.forEach(section => {
        sectionObserver.observe(section);
    });
</script>
</html>
<?php

?>