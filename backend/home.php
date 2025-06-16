<?php
session_start(); // Phải có để đọc dữ liệu session
if (!isset($_SESSION['user_profile'])) {
    header("Location: create_profile.php"); // hoặc index.php nếu đó là form tạo profile
    exit;
}
$profile = $_SESSION['user_profile'] ?? null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Trang chính</title>
    <link rel="stylesheet" href="../asset/home.css">
    <link href="https://fonts.cdnfonts.com/css/shablagoo" rel="stylesheet">
    <script src="https://kit.fontawesome.com/87daf9c073.js" crossorigin="anonymous"></script>
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
    <div class="container">
        <div class="content">
            <div class="profile-card">
                <div class="pic_section">
                    <div class="profile-name">Mia Khalifa Fake</div>
                    <div class="picture">
                        <img src="../images/mid.png" alt="">    
                    </div>
                </div>

                <div class="action-buttons">
                    <button class="action-btn nope-btn">Nope</button>
                    <button class="action-btn like-btn">Like</button>
                    <button class="action-btn">Open Profile</button>
                    <button class="action-btn">Close Profile</button>
                    <button class="action-btn super-like-btn">Super Like</button>
                    <button class="action-btn">Next Photo</button>
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
            </div>
        </div>
        <div class="head_right">
            <div class="pro_icon">
                <div class="your_profile">
                    <div class="profile">
                        <?php if ($profile): ?>
                            <img src="<?= htmlspecialchars($profile['avatar']) ?>" alt="Avatar" width="40" height="40" style="border-radius: 50%;">
                            <h2><?= htmlspecialchars($profile['name']) ?></h2>
                        <?php else: ?>
                            <p>No profile loaded.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="icons">
                    <div class="icon-circle"><i class="fas fa-bolt"></i></div>
                    <div class="icon-circle"><i class="fas fa-th-large"></i></div>
                    <div class="icon-circle"><i class="fas fa-suitcase"></i></div>
                    <div class="icon-circle"><i class="fas fa-shield-alt"></i></div>
                </div>
            </div>
            
            <div class="header">
                <h1>Start Matching</h1>
            </div>
            
            <div class="matches-section">
                <p>Matches will appear here once you start to Like people. You can message them directly from here when you're ready to spark up the conversation.</p>
            </div>
        </div>
    </div>
    <?php if (!empty($_SESSION['avatar_error'])): ?>
    <div class="alert alert-danger">
        <?php echo htmlspecialchars($_SESSION['avatar_error']); ?>
        <?php unset($_SESSION['avatar_error']); ?>
    </div>
    <?php endif; ?>
</body>
</html>
