<?php
session_start();  // Ensure session is started

// Import DB config file
require_once 'config/Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Establish DB connection
    try {
        $dbCon = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
        $dbCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $th) {
        echo "Connection failed: " . $th->getMessage();
        exit;
    }

    // Check if the email exists in the database
    $stmt = $dbCon->prepare("SELECT * FROM login WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {
            // Store user data in session
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email']; // Store email in session
            header("Location: bird-app.php");
            exit;
        } else {
            echo "<p>Incorrect password. Please try again.</p>";
        }
    } else {
        echo "<p>Email not found. Please register first.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link rel="stylesheet" href="style0.css">
</head>
<body>

  <header>
    <h1>Welcome to AVICAST</h1>
  </header>

  <div class="forms-container">
    <div class="wrapper" id="login-form">
        <form action="login.php" method="POST">
            <h1>Login</h1>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required />
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required />
            </div>
            <div class="remember-forgot">
                <label>
                    <input type="checkbox" name="remember_me" /> Remember me
                </label>
                <a href="Google.com">Forgot Password?</a>
            </div>
            <button type="submit" class="button">Login</button>
            <div class="register-link">
                <p>Don't have an account? <a href="javascript:void(0);" id="show-register">Register</a></p>
            </div>
        </form>
    </div>

    <div class="wrapper" id="register-form" style="display: none;">
        <form action="register.php" method="POST" onsubmit="return validatePassword()">
            <h1>Register</h1>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required />
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required />
            </div>
            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Password" required />
            </div>
            <div class="input-box">
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required />
            </div>
            <div class="register-link">
                <p>Already have an account? <a href="javascript:void(0);" id="show-login">Login</a></p>
            </div>
            <p class="error-message" id="error-message" style="color: red; display: none;">Passwords do not match.</p>
            <button type="submit" class="button">Register</button>
        </form>
    </div>
</div>

  </div>

  <script>
    // Toggle between Login and Register forms
    document.getElementById('show-register').addEventListener('click', function() {
      document.getElementById('login-form').style.display = 'none';
      document.getElementById('register-form').style.display = 'block';
    });

    document.getElementById('show-login').addEventListener('click', function() {
      document.getElementById('register-form').style.display = 'none';
      document.getElementById('login-form').style.display = 'block';
    });

    // Password validation function
    function validatePassword() {
      var password = document.getElementById("password").value;
      var confirmPassword = document.getElementById("confirm_password").value;
      var errorMessage = document.getElementById("error-message");

      if (password !== confirmPassword) {
        errorMessage.style.display = "block";
        return false;
      } else {
        errorMessage.style.display = "none";
        return true;
      }
    }

    // Live validation
    document.getElementById("confirm_password").addEventListener("input", function() {
      validatePassword();
    });
  </script>

</body>
</html>


