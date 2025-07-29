<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: http://localhost/DATENE/index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Trang chính</title>
    <link rel="stylesheet" href="../asset/profile.css">
    <link href="https://fonts.cdnfonts.com/css/shablagoo" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/minal" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/kynthia" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
</head>
<body>
    <div id="head">
        <div id="head_inner">
            <a href="http://localhost/DATENE/index.php" id="web_name">DATENE</a>
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
    <div class="name">
        <p>
            Create account
        </p>
    </div>
    <div id="particles-js"></div>
    <div class="container">
        <form action="save_profile.php" method="POST" enctype="multipart/form-data">
                <div class="profile_pic">
                    <div class="avatar-wrapper" id="avatarBox">
                        <img src="../images/none.png" alt="Avatar" id="avatarImage">
                    </div>
                    <input type="file" id="avatarInput" name="gallery[]" accept="image/*" style="display: none;">
                    <p>Choose your avatar</p>
                </div>
                <div class="info">
                        <label for="">Name</label><br>
                        <input type="text" name="name" placeholder="Write down your name"> <br>
                        <label for="">Email</label><br>
                        <input type="email" name="email" placeholder="Write down your email"><br>
                        <label for="">Birthday</label><br>

                        <div class="birthday">
                            <div class="month">
                                <label for="">Month</label><br>
                                <input type="number" name="birth_month" placeholder="Month"><br>
                            </div>
                            <div class="day">
                                <label for="">Day</label><br>
                                <input type="number" name="birth_day" placeholder="Day"><br>
                            </div>
                            <div class="year">
                                <label for="">Year</label><br>
                                <input type="number" name="birth_year" placeholder="Year"><br>
                            </div>
                        </div>
                        <input type="hidden" name="gender" id="genderInput">
                        <input type="hidden" name="interest" id="interestInput">
                        <input type="hidden" name="relationship" id="relationshipInput">
                    
                        <h3>Gender</h3>
                            <div class="button-group" id="gender-group">
                                <button class="button" type="button">Man</button>
                                <button class="button" type="button">Woman</button>
                                <button class="button" type="button">Other</button>
                            </div>

                        <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox">
                                    Show my gender on my profile
                                </label>
                            </div>
                    

                        <h3>Interested in</h3>
                            <div class="button-group" id="interest-group">
                                <button class="button" type="button">Men</button>
                                <button class="button" type="button">Women</button>
                                <button class="button" type="button">Everyone</button>      
                            </div>

                        <!-- Nút bấm -->
                        <button id="open-popup" type="button" class="relationship-button">+ Add Relationship Intent</button>

                        <!-- Popup overlay -->
                        <div id="popup-overlay" class="popup-overlay">
                            <div class="popup-content">
                                <h2>What are you looking for?</h2>
                                <p>All good if it changes. There's something for everyone.</p>

                                <div class="relationship-grid" id="relationship-grid">
                                    <div class="relationship-option">💘<br><span>Long-term partner</span></div>
                                    <div class="relationship-option">😍<br><span>Long-term, open to short</span></div>
                                    <div class="relationship-option">🥂<br><span>Short-term, open to long</span></div>
                                    <div class="relationship-option">🎉<br><span>Short-term fun</span></div>
                                    <div class="relationship-option">👋<br><span>New friends</span></div>
                                    <div class="relationship-option">🤔<br><span>Still figuring it out</span></div>
                                </div>

                                <div class="popup-buttons">
                                    <button id="close-popup" class="cancel-button">Cancel</button>
                                    <button id="save-button" class="save-button" disabled>Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="button_container">
                            <button type="submit" id="main-save-button" class="save_button">Save</button>
                        </div>
                </div>
                <div class="sub_pic">
                    <div class="grid">  
                        <div class="avatar-container">
                        <input type="file" accept="image/*">
                        <img>
                        <div class="add-btn">+</div>
                        </div>
                        <div class="avatar-container">
                        <input type="file" accept="image/*">
                        <img>
                        <div class="add-btn">+</div>
                        </div>
                        <div class="avatar-container">
                        <input type="file" accept="image/*">
                        <img>
                        <div class="add-btn">+</div>
                        </div>
                        <div class="avatar-container">
                        <input type="file" accept="image/*">
                        <img>
                        <div class="add-btn">+</div>
                        </div>
                    </div>
                    <div class="grid_text">
                        <h3>
                            Choose your best images to display on your account, so everybody knows you more precisely
                        </h3>
                    </div>
                </div>
        </form>
    </div>
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
    window.addEventListener('resize', () => {
        document.getElementById('particles-js').style.height = `${document.body.scrollHeight}px`;
    });
    const avatarBox = document.getElementById("avatarBox");
    const avatarInput = document.getElementById("avatarInput");
    const avatarImage = document.getElementById("avatarImage");

    avatarBox.addEventListener("click", () => {
      avatarInput.click(); // mở chọn file
    });

    avatarInput.addEventListener("change", (event) => {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          avatarImage.src = e.target.result; // gán ảnh đã chọn vào avatar
        }
        reader.readAsDataURL(file);
      }
    });

    document.querySelectorAll('.avatar-container').forEach(container => {
      const fileInput = container.querySelector('input[type="file"]');
      const img = container.querySelector('img');
      const btn = container.querySelector('.add-btn');

      btn.addEventListener('click', () => fileInput.click());

      fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = e => {
            img.src = e.target.result;
            img.style.display = 'block';
            btn.style.display = 'none'; // ẩn dấu cộng sau khi có ảnh
          };
          reader.readAsDataURL(file);
        }
      });
    });

    function setupSingleSelect(groupId, hiddenInputId) {
    const buttons = document.querySelectorAll(`#${groupId} > .button`);
    const hiddenInput = document.getElementById(hiddenInputId);

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
        buttons.forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
        hiddenInput.value = btn.textContent.trim(); 
        });
    });
    }

    setupSingleSelect('gender-group', 'genderInput');
    setupSingleSelect('interest-group', 'interestInput');

    //làm overlay
    const popup = document.getElementById('popup-overlay');
    const openBtn = document.getElementById('open-popup');
    const closeBtn = document.getElementById('close-popup');
    const saveBtn = document.getElementById('save-button');
    const options = document.querySelectorAll('.relationship-option');

    // Mở popup
    openBtn.addEventListener('click', () => {
    popup.style.display = 'flex';
    });

    // Đóng popup
    closeBtn.addEventListener('click', () => {
    popup.style.display = 'none';
    });

    // Toggle chọn
    options.forEach(option => {
    option.addEventListener('click', () => {
        option.classList.toggle('selected');

        const selected = document.querySelectorAll('.relationship-option.selected');
        if (selected.length > 0) {
        saveBtn.disabled = false;
        savebtn.classList.add('enabled');
        } else {
        saveBtn.disabled = true;
        saveBtn.classList.remove('enabled');
        }
    });
    });
    // Xử lý nút Save trong popup Relationship Intent
    const relationshipInput = document.getElementById('relationshipInput');

    saveBtn.addEventListener('click', (e) => {
        e.preventDefault(); // Ngăn không cho form submit
        
        if (!saveBtn.disabled) {
            const selected = document.querySelectorAll('.relationship-option.selected');
            const values = Array.from(selected).map(el => el.querySelector('span').innerText.trim());
            relationshipInput.value = values.join(', ');
            
            // Đóng popup sau khi lưu
            document.getElementById('popup-overlay').style.display = 'none';
        }
    });

    // Xử lý nút Save chính của form
    document.getElementById('main-save-button').addEventListener('click', (e) => {

    });
    // Lưu và đóng popup
    saveBtn.addEventListener('click', () => {
    if (!saveBtn.disabled) {
        popup.style.display = 'none';
        // Bạn có thể xử lý thêm để lưu lựa chọn tại đây
    }
    });
    // Xử lí các giới hạn nhập
document.querySelector("form").addEventListener("submit", function (e) {
    const name = document.querySelector('input[name="name"]');
    const email = document.querySelector('input[name="email"]');
    const month = document.querySelector('input[name="birth_month"]');
    const day = document.querySelector('input[name="birth_day"]');
    const year = document.querySelector('input[name="birth_year"]');

    // Kiểm tra tên dài
    if (name.value.length > 255) {
        alert("Tên không được vượt quá 255 ký tự.");
        e.preventDefault();
        return;
    }

    // Regex kiểm tra email đơn giản
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value)) {
        alert("Email không hợp lệ.");
        e.preventDefault();
        return;
    }

    // Giới hạn tháng, ngày, năm
    if (month.value < 1 || month.value > 12) {
        alert("Tháng phải từ 1 đến 12.");
        e.preventDefault();
        return;
    }

    if (day.value < 1 || day.value > 31) {
        alert("Ngày phải từ 1 đến 31.");
        e.preventDefault();
        return;
    }

    if (year.value > 2025) {
        alert("Năm sinh không được lớn hơn 2025.");
        e.preventDefault();
        return;
    }
});

  </script>
</body>
</html>
