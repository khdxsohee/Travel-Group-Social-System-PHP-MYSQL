<?php
session_start();
include('../config/db.php');

if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header('Location: home.php');
            exit();
        } else {
            $_SESSION['error'] = "Incorrect password.";
        }
    } else {
        $_SESSION['error'] = "No user found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Travel Group Social System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            padding: 40px 30px;
            width: 100%;
            max-width: 400px;
            animation: slideIn 0.5s ease-in-out;
        }

        @keyframes slideIn {
            from { transform: translateY(40px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .header {
            position: absolute;
            top: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            color: #fff;
            width: 100%;
        }

        .container h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            color: #fff;
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: none;
            outline: none;
            background: rgba(255, 255, 255, 0.3);
            color: #fff;
            font-size: 14px;
        }

        input::placeholder {
            color:rgb(255, 255, 255);
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #ffffff;
            color: #333;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #f0f0f0;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            color: #fff;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            color: #fff;
            font-size: 13px;
            margin-top: 10px;
        }

        .footer a {
            color: #fff;
            font-weight: 500;
            text-decoration: underline;
        }

        .footer a:hover {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="header">Travel Group Social System - Login</div>

<div class="container">
    <h2>Login</h2>

    <?php
    if (isset($_SESSION['error'])) {
        echo '<div class="message" style="color: #ffdddd; background-color: #ff4c4c33; padding: 10px; border-radius: 6px;">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo '<div class="message" style="color: #d4ffd4; background-color: #4caf5033; padding: 10px; border-radius: 6px;">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);
    }
    ?>

    <form method="POST" action="">
        <label>Email:</label>
        <input type="email" name="email" placeholder="Enter your email" required>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Enter your password" required>

        <input type="submit" value="Login">
    </form>

    <div class="footer">
        Don't have an account? <a href="register.php">Register Here</a>
    </div>
</div>

</body>
</html>
