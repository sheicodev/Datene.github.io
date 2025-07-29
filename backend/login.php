<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login with Google</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://accounts.google.com/gsi/client" async defer></script>
  <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        display: flex;
        height: 100vh;
        align-items: center;
        justify-content: center;
    }
    .container {
        background-color: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

  </style>
</head>
<body>
  <div class="container">
    <h2>Login with Google</h2>
    <div id="g_id_onload"
         data-client_id="543114283027-77gg78k07a522qfi7ta6sfkk49rfg64g.apps.googleusercontent.com"
         data-login_uri="http://localhost/DATENE/backend/google-login.php"
         data-auto_prompt="false">
    </div>
    <div class="g_id_signin" data-type="standard"></div>
  </div>
</body>
</html>
