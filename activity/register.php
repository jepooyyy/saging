<?php
session_start();  // Start session

// Import Database Connection
require_once 'config/Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "<p style='color:red;'>Passwords do not match. Please try again.</p>";
        exit;
    }

    try {
        // Check if username or email already exists
        $stmt = $dbCon->prepare("SELECT * FROM login WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<p style='color:red;'>Username or Email already exists. Please choose another one.</p>";
            exit;
        }

        // Hash the password before storing it in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into the database
        $insert = $dbCon->prepare("INSERT INTO login (username, email, password) VALUES (:username, :email, :password)");
        $insert->bindParam(':username', $username, PDO::PARAM_STR);
        $insert->bindParam(':email', $email, PDO::PARAM_STR);
        $insert->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        
        if ($insert->execute()) {
            echo "<p style='color:green;'>Registration successful! You can now <a href='login.php'>log in</a>.</p>";
        } else {
            echo "<p style='color:red;'>Registration failed. Please try again.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Database error: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style0.css">
</head>
<body>

<header>
    <h1>Avicast</h1>
</header>

<!-- Wrapper for Register Form -->
<div class="forms-container">
    <div class="wrapper" id="register-form">
        <form action="register.php" method="POST">
            <h1>Register</h1>

            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required />
            </div>

            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required />
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required />
            </div>

            <div class="input-box">
                <input type="password" name="confirm_password" placeholder="Confirm Password" required />
            </div>

            <button type="submit" class="button">Register</button>

            <div class="register-link">
                <p>Already have an account? <a href="login.php">Log in</a></p>
            </div>
        </form>
    </div>
</div>

</body>
</html>
