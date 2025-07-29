<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Debug: Log user ID đang xem
error_log("User ".$_SESSION['user_id']." viewing liked list");

// Kiểm tra dữ liệu trong bảng likes
$checkLikes = $pdo->query("SELECT * FROM likes WHERE liker_id = ".$_SESSION['user_id']);
error_log("Found ".$checkLikes->rowCount()." likes for this user");

// Truy vấn danh sách đã like
$stmt = $pdo->prepare("
    SELECT u.UserID, u.Username, u.Gender, u.Avatar, u.Email, 
           p.Bio, p.Interests,
           l.created_at 
    FROM likes l
    JOIN user u ON l.liked_id = u.UserID
    LEFT JOIN profile p ON u.UserID = p.UserID
    WHERE l.liker_id = ?
    ORDER BY l.created_at DESC
");

$stmt->execute([$_SESSION['user_id']]);
$likedUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Debug: Log kết quả
error_log("Liked users count: ".count($likedUsers));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trang chính</title>
    <link rel="stylesheet" href="../asset/liked_user.css">
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
        <link href="https://fonts.cdnfonts.com/css/shablagoo" rel="stylesheet">
</head>
<body>
    <div id="head">
        <div id="head_inner">
            <a href="home.php"><p id="web_name">DATENE</p></a>
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
        <div class="text_container">
            <h1>Danh sách bạn đã like ❤️</h1>
        </div>

        <?php if (empty($likedUsers)): ?>

        <?php else: ?>
            <div class="user-list">
                <?php foreach ($likedUsers as $user): ?>
                    <div class="user-card">
                        <img src="../images/<?= htmlspecialchars($user['Avatar'] ?? 'default-avatar.jpg') ?>" 
                             alt="Avatar" class="user-avatar">
                        <div class="user-info">
                            <div class="user-details">
                                <h3><?= htmlspecialchars($user['Username']) ?></h3>
                                <p>Giới tính: <?= htmlspecialchars($user['Gender']) ?></p>
                                <p>Email: <?= htmlspecialchars($user['Email']) ?></p>
                                <p class="like-time">
                                    Đã like vào: <?= date('H:i d/m/Y', strtotime($user['created_at'])) ?>
                                </p>
                            </div>
                            <div class="user-actions">
                                <button class="delete-btn" onclick="deleteUser(<?= $user['UserID'] ?>)">❌ Xoá</button>
                                <button class="chat-btn" 
                                onclick="openChat(
                                    <?= $user['UserID'] ?>, 
                                    '<?= htmlspecialchars($user['Username']) ?>', 
                                    '<?= addslashes($user['Bio'] ?? '') ?>', 
                                    '<?= addslashes($user['Interests'] ?? '') ?>'
                                )">💬 Nhắn tin</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div style="margin-top: 30px; text-align: center;" class="return">
            <a href="home.php" style="text-decoration: none; color: #007bff;">← Quay lại trang chủ</a>
        </div>
    </div>
    <div id="chat-box">
        <div id="chat-header">Đang nhắn với...</div>
        <div id="chat-messages"></div>
        <div id="chat-input">
            <input type="text" id="messageInput" placeholder="Nhập tin nhắn...">
            <button onclick="sendMessage()">Gửi</button>
        </div>
    </div>

    <div id="delete-overlay" style="display:none;">
        <div class="overlay-background"></div>
        <div class="confirm-box">
            <p>Bạn có chắc muốn xoá người này khỏi danh sách like không?</p>
            <div class="button-group">
                <button id="cancel-delete">Huỷ</button>
                <button id="confirm-delete">Xoá</button>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    let currentChatUserId = null;
    let chatHistory = [];

    window.onload = function () {
        particlesJS("particles-js", {
            particles: {
                number: { value: 8 },
                shape: {
                    type: "image",
                    image: {
                        src: "http://localhost/DATENE/images/heart.png",
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
    };

    window.addEventListener('resize', () => {
        document.getElementById('particles-js').style.height = `${document.body.scrollHeight}px`;
    });

    function openChat(userId, username, bio = '', interests = '') {
        currentChatUserId = userId;
        chatHistory = [];
        document.getElementById("chat-box").style.display = "flex";
        document.getElementById("chat-header").innerText = "Đang nhắn với " + username;
        document.getElementById("chat-messages").innerHTML = "";
        
        // Lưu thông tin bio và interests cho phiên làm việc hiện tại
        currentUserBio = bio;
        currentUserInterests = interests;
        localStorage.setItem(`chat_meta_${userId}`, JSON.stringify({
            bio: bio,
            interests: interests
        }));
        loadChat(userId); // 🔁 Load lại lịch sử và gán lại bio/interests
    }


    function appendUser(text) {
        const chatBox = document.getElementById('chat-messages');
        const el = document.createElement('p');
        el.className = 'from-you';
        el.textContent = text;
        chatBox.appendChild(el);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function appendBot(text) {
        const chatBox = document.getElementById('chat-messages');
        const el = document.createElement('p');
        el.className = 'from-them';
        el.textContent = text;
        chatBox.appendChild(el);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function appendTyping() {
        const chatBox = document.getElementById('chat-messages');
        const el = document.createElement('p');
        el.className = 'from-them typing';
        el.textContent = '...';
        chatBox.appendChild(el);
        chatBox.scrollTop = chatBox.scrollHeight;
        return el;
    }

    function sendMessage() {
        const input = document.querySelector("#messageInput");
        const message = input.value.trim();
        if (!message || currentChatUserId === null) return;

        appendUser(message);
        saveMessage(currentChatUserId, message, 'me');

        input.value = '';

        const typingEl = appendTyping();

        const currentBio = document.querySelector('.bio-text')?.textContent || '';
        const currentInterests = Array.from(document.querySelectorAll('.interests-list .interest-tag'))
            .map(el => el.textContent).join(', ');

        fetch('bot_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'text=' + encodeURIComponent(message)
                + '&bio=' + encodeURIComponent(currentUserBio)
                + '&interests=' + encodeURIComponent(currentUserInterests)
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
            saveMessage(currentChatUserId, reply, 'them');
        })
        .catch(err => {
            typingEl.remove();
            appendBot("Không kết nối được tới bot 😓");
            console.error(err);
        });
    }

    // Enter để gửi tin nhắn
    const input = document.getElementById('messageInput');
    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    });

    // Lưu tin nhắn theo từng người
    function saveMessage(userId, message, from = 'me') {
        const key = `chat_${userId}`;
        let chat = JSON.parse(localStorage.getItem(key)) || [];
        chat.push({ from, message, time: Date.now() });
        localStorage.setItem(key, JSON.stringify(chat));
    }

    // Load lại lịch sử khi mở chat
    function loadChat(userId) {
        const key = `chat_${userId}`;
        let chat = JSON.parse(localStorage.getItem(key)) || [];
        const box = document.getElementById('chat-messages');
        box.innerHTML = '';

        chat.forEach(msg => {
            const el = document.createElement('p');
            el.className = msg.from === 'me' ? 'from-you' : 'from-them';
            el.textContent = msg.message;
            box.appendChild(el);
        });

        // Load bio + interests của người này
        const meta = JSON.parse(localStorage.getItem(`chat_meta_${userId}`)) || {};
        currentUserBio = meta.bio || '';
        currentUserInterests = meta.interests || '';
    }


    function displayMessage(message, from) {
        const chatBox = document.getElementById('chatBox');
        const msgDiv = document.createElement('div');
        msgDiv.className = from === 'me' ? 'message me' : 'message partner';
        msgDiv.textContent = message;
        chatBox.appendChild(msgDiv);
    }

    function openChatWith(partnerId) {
        currentPartnerId = partnerId;
        document.getElementById('chatBox').innerHTML = '';
        loadChat(partnerId);
    }

    let deleteUserIdToRemove = null;

    function deleteUser(userId) {
        deleteUserIdToRemove = userId;
        document.getElementById("delete-overlay").style.display = "flex";
    }

    document.getElementById("cancel-delete").addEventListener("click", () => {
        document.getElementById("delete-overlay").style.display = "none";
        deleteUserIdToRemove = null;
    });

    document.getElementById("confirm-delete").addEventListener("click", () => {
        if (deleteUserIdToRemove !== null) {
            fetch('unlike_user.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ user_id: deleteUserIdToRemove })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert("Xoá thất bại.");
                }
            })
            .catch(() => {
                alert("Đã xảy ra lỗi.");
            })
            .finally(() => {
                document.getElementById("delete-overlay").style.display = "none";
                deleteUserIdToRemove = null;
            });
        }
    });

</script>
