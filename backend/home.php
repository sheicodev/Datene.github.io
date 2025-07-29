<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: http://localhost/DATENE/index.php");
    exit;
}

// Load dữ liệu profile nếu chưa có trong session
if (!isset($_SESSION['user_profile'])) {
    require __DIR__ . '/db.php';
    $stmt = $pdo->prepare("SELECT * FROM user WHERE Email = ?");
    $stmt->execute([$_SESSION['email']]);
    $_SESSION['user_profile'] = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Trang chính</title>
    <link rel="stylesheet" href="../asset/home.css">
    <link href="https://fonts.cdnfonts.com/css/shablagoo" rel="stylesheet">
    <script src="https://kit.fontawesome.com/87daf9c073.js" crossorigin="anonymous"></script>
    <link href="https://fonts.cdnfonts.com/css/cocogoose" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
</head>
<body>
    <div id="head">
        <div id="head_inner">
            <a href="index.php"><p id="web_name">DATENE</p></a>
        </div>
        <div id="head_inner">
            </div>
        <div id="head_inner">
            </div>
        <div id="head_inner">
            
        </div>
    </div>
    <div id="particles-js"></div>
    <div class="container">
        <div class="content">
            <div class="profile-card">
                <div class="pic_section">
                    <div class="profile-name">Mia Khalifa Fake</div>
                        <div class="picture">
                            <img id="current-avatar" src="../images/mid.png" alt="">
                            <div class="action-buttons">
                                <button class="action-btn nope-btn"><img src="../images/X-removebg-preview.png" alt=""></button>
                                <button class="action-btn like-btn" 
                                        data-user-id="<?php 
                                            if (isset($users) && is_array($users) && isset($users[$currentIndex]['UserID'])) {
                                                echo htmlspecialchars($users[$currentIndex]['UserID']);
                                            } else {
                                                echo '';
                                            }
                                        ?>">
                                    <img src="../images/love_removebg.png" alt="Like">
                                </button>

                                    <button class="action-btn" id="prev-profile-btn">
                                        <img src="../images/left-arrow-removebg-preview.png" alt="Previous">
                                    </button>
                                    <button class="action-btn" id="next-profile-btn">
                                        <img src="../images/right_arrow.png" alt="Next">
                                    </button>
                            </div>
                        </div> 
                </div>
            </div>
            
            <div class="interests-section">
                <h2>Get Love</h2>
                <div class="interests-list">
                    <span class="interest-tag">Online Games</span>
                    <span class="interest-tag">Music bands</span>
                    <span class="interest-tag">Equality</span>
                    <span class="interest-tag">League of Legends</span>
                    <span class="interest-tag">Inclusivity</span>
                </div>
                <h2>Bio</h2>
                <div class="bio">
                    <span class="bio-text">Online Games</span>
                </div>
            </div>
        </div>
        <div class="head_right">
            <div class="pro_icon">
                <div class="your_profile">
                    <div class="profile">
                        <?php if (isset($_SESSION['user_profile'])): 
                            $profile = $_SESSION['user_profile'];
                        ?>
                            <?php if (!empty($profile['avatar'])): ?>
                                <a href="account.php"> <img src="<?= htmlspecialchars($profile['avatar']) ?>" alt="Avatar" width="40" height="40" style="border-radius: 50%;"></a>
                            <?php else: ?>
                                <a href="account.php"><img src="../images/default.png" alt="Avatar" width="40" height="40" style="border-radius: 50%;"></a>
                            <?php endif; ?>
                            <a href="account.php"><h2><?= htmlspecialchars($profile['name'] ?? 'No name') ?></h2></a>
                        <?php else: ?>
                            <p>No profile loaded. Please create a profile first.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="icons">
                    <div class="icon-circle">
                        <a href="liked_user.php">
                            <i class="fa-solid fa-star"></i>
                        </a>
                    </div>
                    <h3>Your Favorite</h3>
                </div>
            </div>
            <div class="nav"></div>
            <div class="pro_pic"></div>
            <div class="texting">
                <div class="header">
                    <h1>Start Matching</h1>
                </div>
                
                <div class="matches-section">
                    <p>Matches will appear here once you start to Like people. You can message them directly from here when you're ready to spark up the conversation.</p>
                </div>
            </div>
        </div>
    </div>
    <div id="match-overlay" class="match-hidden">
        <div class="match-avatars">
            <img id="user-avatar" src="" alt="You">
            <div class="match-heart">❤️</div>
            <img id="target-avatar" src="" alt="Target">
        </div>
        <h2 class="match-text">Matching...</h2>
    </div>
    <?php if (!empty($_SESSION['avatar_error'])): ?>
    <div class="alert alert-danger">
        <?php echo htmlspecialchars($_SESSION['avatar_error']); ?>
        <?php unset($_SESSION['avatar_error']); ?>
    </div>
    <?php endif; ?>
<script>
    // tim bay bay
    window.onload = function () {
    // Khởi động particlesJS
        particlesJS("particles-js", {
            particles: {
            number: { value: 8 },
            shape: {
                type: "image",
                image: {
                src: "http://localhost/DATENE/images/heart.png",  // đã đúng
                width: 20,
                height: 20
                }
            },
            size: { value: 32 },
            move: { speed: 2.5 },
            opacity: { value: 1 }
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
    let users = [];                     // Danh sách tất cả người dùng từ server
    let viewedUsers = [];                // Lưu các chỉ số đã xem theo thứ tự
    let currentIndexInHistory = -1;      // Vị trí hiện tại trong history
    let chatHistory = [];                // mỗi phần tử: {role:'user'|'assistant', content:'text'}

    // Load dữ liệu người dùng khi trang load
    window.addEventListener('DOMContentLoaded', () => {
        fetch('all_profiles.php')
            .then(res => res.json())
            .then(data => {
                users = data;
                showNextUser(); // Hiển thị người đầu tiên ngẫu nhiên
            })
            .catch(err => {
                console.error('Không thể load danh sách người dùng:', err);
            });
    });

    // Hiển thị profile theo index
    function showUserProfile(index) {
        const user = users[index];
        if (!user) return;

        document.querySelector('.profile-name').textContent = user.Username;

        const interestsList = document.querySelector('.interests-list');
        interestsList.innerHTML = '';
        if (user.Interests) {
            const tags = user.Interests.split(',').map(s => s.trim());
            tags.forEach(tag => {
                const span = document.createElement('span');
                span.className = 'interest-tag';
                span.textContent = tag;
                interestsList.appendChild(span);
            });
        }
        const bioElement = document.querySelector('.bio-text');
        bioElement.textContent = user.Bio ? user.Bio : 'No bio available';

        // Cập nhật avatar

        const imgElement = document.querySelector('.picture img');
        imgElement.src = user.Avatar ? `../images/${user.Avatar}` : '../images/default-avatar.jpg';
        imgElement.onerror = function () {
            this.src = '../images/default-avatar.jpg';
        };
        document.querySelector('.like-btn').setAttribute('data-user-id', user.UserID);
    }

    // Hiển thị người kế tiếp (ngẫu nhiên và không lặp lại)
    function showNextUser() {
        if (currentIndexInHistory < viewedUsers.length - 1) {
            // Nếu đã đi lùi và bây giờ muốn đi tới lại
            currentIndexInHistory++;
            showUserProfile(viewedUsers[currentIndexInHistory]);
            return;
        }

        const remainingIndices = users
            .map((_, i) => i)
            .filter(i => !viewedUsers.includes(i));

        if (remainingIndices.length === 0) {
            alert('Hết người để xem rồi!');
            return;
        }

        const randomIndex = remainingIndices[Math.floor(Math.random() * remainingIndices.length)];
        viewedUsers.push(randomIndex);
        currentIndexInHistory++;
        showUserProfile(randomIndex);
    }

    // Hiển thị người trước đó
    function showPreviousUser() {
        if (currentIndexInHistory > 0) {
            currentIndexInHistory--;
            const previousIndex = viewedUsers[currentIndexInHistory];
            showUserProfile(previousIndex);
        } else {
            alert('Đang ở người đầu tiên rồi.');
        }
    }

    document.getElementById('next-profile-btn').addEventListener('click', showNextUser);
    document.getElementById('prev-profile-btn').addEventListener('click', showPreviousUser);

    document.querySelector('.like-btn').addEventListener('click', function (e) {
        for (let i = 0; i < 5; i++) {  // 👈 Số tim bay mỗi lần (tùy chỉnh)
            createFlyingHeart(e);
        }
    });

    // Thêm hàm kiểm tra user hiện tại
function getCurrentUser() {
    if (users.length === 0 || currentIndexInHistory < 0) return null;
    return users[viewedUsers[currentIndexInHistory]];
}

// Sửa lại hàm likeUser
    function likeUser(userId) {
        console.log("Attempting to like user ID:", userId);
        
        fetch('like_user.php', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            credentials: 'include', // ⚠️ Cực kỳ quan trọng
            body: JSON.stringify({ liked_user_id: userId })
        })
        .then(async response => {
            // Kiểm tra content-type trước khi parse JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                throw new Error(`Invalid content-type. Response: ${text}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
            } else {
                alert('Lỗi: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xử lý like. Vui lòng thử lại.');
        });
    }

    // Cập nhật event listener
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            likeUser(userId);
        });
    });
    fetch('all_profiles.php')
    .then(res => {
        console.log('Response status:', res.status); // Phải là 200
        return res.json();
    })
    .then(data => {
        console.log('Loaded users:', data); // Kiểm tra có UserID không
        users = data;
    })  
    function createFlyingHeart(event) {
        const heart = document.createElement('div');
        heart.className = 'heart-fly';
        heart.innerHTML = '❤️';

        const buttonRect = event.currentTarget.getBoundingClientRect();
        const x = buttonRect.left + buttonRect.width / 2;
        const y = buttonRect.top + buttonRect.height / 2;

        heart.style.left = `${x}px`;
        heart.style.top = `${y}px`;

        // Tạo ngẫu nhiên hướng bay
        const randomX = (Math.random() - 0.5) * 100;  // -50px đến +50px
        const randomY = -Math.random() * 100 - 50;    // Bay lên trên -50px đến -150px

        heart.style.setProperty('--x-move', `${randomX}px`);
        heart.style.setProperty('--y-move', `${randomY}px`);

        document.body.appendChild(heart);

        setTimeout(() => {
            heart.remove();
        }, 1200);
    }
    document.querySelector('.nope-btn').addEventListener('click', function () {
        flyOutAndNext('left');
    });

    document.querySelector('.like-btn').addEventListener('click', function (e) {
        for (let i = 0; i < 5; i++) createFlyingHeart(e); // Nếu muốn tim bay kèm
        flyOutAndNext('right');
    });

    function flyOutAndNext(direction) {
        const img = document.querySelector('.picture img');

        // Thêm class bay trái/phải
        img.classList.add(direction === 'right' ? 'fly-right' : 'fly-left');

        // Đợi hiệu ứng hoàn tất (600ms), rồi show ảnh mới
        setTimeout(() => {
            // Reset lại ảnh về trạng thái ban đầu
            img.classList.remove('fly-right', 'fly-left');

            // Hiển thị người tiếp theo
            showNextUser();
        }, 600);
    }

    document.querySelector('.header h1').addEventListener('click', startMatching);

    function startMatching() {
        const matchOverlay = document.getElementById('match-overlay');
        const userAvatar = document.getElementById('user-avatar');
        const targetAvatar = document.getElementById('target-avatar');

        const myAvatar = <?= json_encode($_SESSION['user_profile']['avatar'] ?? 'default-avatar.jpg') ?>;
        userAvatar.src = myAvatar;

        const currentTargetAvatar = document.getElementById('current-avatar').src;
        targetAvatar.src = currentTargetAvatar;

        matchOverlay.classList.remove('match-hidden');

        setTimeout(() => {
            matchOverlay.classList.add('match-hidden');
            showChat();
        }, 3000);
    }

    function showStartMatching() {
        const chatBox = document.querySelector('.texting');
        chatBox.innerHTML = `
            <div class="header">
                <h1 id="start-matching-btn">Start Matching</h1>
            </div>
            <div class="matches-section">
                <p>Matches will appear here once you start to Like people. 
                You can message them directly from here when you're ready to spark up the conversation.
                </p>
            </div>
        `;
        // Gắn sự kiện click cho nút Start Matching mới render
        document.getElementById('start-matching-btn').addEventListener('click', startMatching);
    }

    /* ---------- CHAT UI ---------- */
    function showChat() {
        const chatBox = document.querySelector('.texting');
        chatBox.innerHTML = `
            <div class="chat-header"><h2>You matched!</h2></div>
            <div class="chat-messages" id="chat-messages"></div>
            <div class="chat-input">
                <input type="text" id="chat-input" placeholder="Type a message...">
                <button id="send-btn">Send</button>
            </div>
        `;

        chatHistory = []; // Reset lịch sử chat khi bắt đầu chat mới
        appendBot("Hi, nice to meet you! 😊");
        chatHistory.push({ role: 'assistant', content: 'Hi, nice to meet you! 😊' });

        document.getElementById('send-btn').addEventListener('click', sendMessage);
        document.getElementById('chat-input').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendMessage();
        });
    }

    // Thêm tin nhắn từ user
    function appendUser(text) {
        const chatBox = document.getElementById('chat-messages');
        const el = document.createElement('p');
        el.className = 'from-you';
        el.textContent = text;
        chatBox.appendChild(el);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // Thêm tin nhắn từ bot
    function appendBot(text) {
        const chatBox = document.getElementById('chat-messages');
        const el = document.createElement('p');
        el.className = 'from-them';
        el.textContent = text;
        chatBox.appendChild(el);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // Thêm hiệu ứng đang gõ
    function appendTyping() {
        const chatBox = document.getElementById('chat-messages');
        const el = document.createElement('p');
        el.className = 'from-them typing';
        el.textContent = '...';
        chatBox.appendChild(el);
        chatBox.scrollTop = chatBox.scrollHeight;
        return el;
    }

        // Gửi tin nhắn từ user tới bot
    function sendMessage() {
        const input = document.getElementById('chat-input');
        const message = input.value.trim();
        if (!message) return;

        appendUser(message);
        chatHistory.push({ role: 'user', content: message });
        input.value = '';

        const typingEl = appendTyping();

        const currentBio = document.querySelector('.bio-text').textContent;
        const currentInterests = Array.from(document.querySelectorAll('.interests-list .interest-tag'))
            .map(el => el.textContent)
            .join(', ');

        fetch('bot_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'text=' + encodeURIComponent(message)
                + '&bio=' + encodeURIComponent(currentBio)
                + '&interests=' + encodeURIComponent(currentInterests)
        })

            .then(res => res.json())
            .then(data => {
                typingEl.remove();
                if (data.error) {
                    appendBot("Lỗi bot: " + data.error);
                    return;
                }
                const reply = data.choices?.[0]?.message?.content || "(Bot im lặng...)";
                appendBot(reply);
                chatHistory.push({ role: 'assistant', content: reply });
            })
            .catch(err => {
                typingEl.remove();
                appendBot("Không kết nối được tới bot 😓");
                console.error(err);
            });
    }

    /* ---------- RESET CHAT ---------- */
    function resetChat() {
        showStartMatching(); // Quay lại màn hình start matching
        chatHistory = [];    // Reset lịch sử chat
    }

    /* ---------- GẮN SỰ KIỆN CHUYỂN PROFILE ---------- */
    document.querySelector('.like-btn').addEventListener('click', () => {
        resetChat();
        flyOutAndNext('right'); // Vẫn giữ hiệu ứng chuyển ảnh
    });

    document.querySelector('.nope-btn').addEventListener('click', () => {
        resetChat();
        flyOutAndNext('left');
    });

    document.getElementById('next-profile-btn').addEventListener('click', () => {
        resetChat();
        showNextUser();
    });

    document.getElementById('prev-profile-btn').addEventListener('click', () => {
        resetChat();
        showPreviousUser();
    });

    /* ---------- GỌI LẦN ĐẦU KHI LOAD TRANG ---------- */
    document.addEventListener('DOMContentLoaded', showStartMatching);
</script>
</body>
</html>
