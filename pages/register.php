<?php
session_start();
include('../config/db.php');

if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
    if ($check->num_rows > 0) {
        $_SESSION['error'] = "Email already registered.";
    } else {
        $conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
        $_SESSION['success'] = "Registration successful. Please login.";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Travel Group Social System</title>
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

        input[type="text"],
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

<div class="header">Travel Group Social System - Register</div>

<div class="container">
    <h2>Create Account</h2>

    <?php
    if (isset($_SESSION['error'])) {
        echo '<div class="message" style="color: #ffdddd; background-color: #ff4c4c33; padding: 10px; border-radius: 6px;">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    ?>

    <form method="POST" action="">
        <label>Full Name:</label>
        <input type="text" name="name" placeholder="Your full name" required>

        <label>Email:</label>
        <input type="email" name="email" placeholder="Enter email" required>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Create a password" required>

        <input type="submit" value="Register">
    </form>

    <div class="footer">
        Already have an account? <a href="login.php">Login Here</a>
    </div>
</div>

</body>
</html>
