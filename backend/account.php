<?php
session_start();
$user = $_SESSION['user_profile'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../asset/account.css">
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
        <div class="sidebar">
            <h2>Account<br>Management</h2>
            <ul>
            <li>YOUR NAME</li>
            <li>PERSONAL INFORMATION</li>
            <li>USER ACCOUNT SIGN-IN</li>
            <li>CONNECTED ACCOUNTS</li>
            <li>MULTI-FACTOR AUTHENTICATION</li>
            <li>LOGIN MANAGEMENT</li>
            <li>COMMUNICATION PREFERENCES</li>
            </ul>
        </div>

        <div class="main-content">
            <!-- Riot ID box -->
            <div class="box">
            <h3>Your Name</h3>
            <p>Your name is used by players to find you through the social panel in our apps.</p>
            <div class="input-group">
                <div class="input-field">
                <label>Your Name</label>
                <input type="text" placeholder="Enter your name pls" value="<?= isset($_SESSION['user_profile']['name']) ? htmlspecialchars($_SESSION['user_profile']['name']) : '' ?>">
                </div>
                <div class="input-field">
                <label>TAGLINE</label>
                <input type="text" placeholder="Enter your tag pls">
                </div>
            </div>
            <button class="save-btn">SAVE CHANGES</button>
            </div>

            <!-- Personal Info box -->
            <div class="box">
            <h3>Personal Information</h3>
            <p>This information is private and will not be shared with other players. Read the 
                <a href="#">Riot Privacy Notice</a> anytime!</p>
            <div class="input-group">
                <div class="input-field">
                <label>EMAIL ADDRESS</label>
                <input type="text" placeholder="bao*****@gm***.com" value="<?= isset($_SESSION['user_profile']['email']) ? htmlspecialchars($_SESSION['user_profile']['email']) : '' ?>">
                </div>
                <div class="input-field">
                <label>COUNTRY / REGION</label>
                <input type="text" value="VNM">
                </div>
            </div>
            <button class="save-btn">SAVE AND VERIFY</button>
            </div>

            <!-- User Account sign in -->
            <div class="box">
            <h3>User Account Sign-in</h3>
            <p>This information is private and will not be shared with other players. Read the <a href="#">Riot Privacy Notice</a> anytime!</p>
            <div class="input-group">
                <div class="input-field">
                <label>EMAIL ADDRESS</label>
                <input type="text" placeholder="bao*****@gm***.com" value="<?= isset($_SESSION['user_profile']['email']) ? htmlspecialchars($_SESSION['user_profile']['email']) : '' ?>">
                </div>
                <div class="input-field">
                <label>COUNTRY / REGION</label>
                <input type="text" value="VNM">
                </div>
            </div>
            <button class="save-btn">SAVE AND VERIFY</button>
            </div>
        </div>
    </div>
</body>
</html>