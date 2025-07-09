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
  :root {
            --primary-color: #007bff;
            --text-color: #fff;
            --section-bg-dark: rgba(0, 0, 0, 0.6);
        }

        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            color: var(--text-color);
            background: transparent;
        }
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            min-height: 100vh;
        }





        .main-header {
            width: 100%;
            padding: 20px 0;
            background-color: rgba(0, 0, 0, 0.6);
            position: relative;
            top: 0;
            z-index: 100;
        }

        .main-header .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo a {
            color: var(--text-color);
            text-decoration: none;
            font-size: 1.8em;
            font-weight: 700;
        }

        .main-nav .nav-links {
            list-style: none;
            display: flex;
            gap: 30px;
        }

        .main-nav .nav-links a {
            color: var(--text-color);
            text-decoration: none;
            font-size: 1em;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .main-nav .nav-links a:hover {
            color: var(--primary-color);
        }

        .nav-controls {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 5px 15px;
        }

        .search-bar input {
            background: none;
            border: none;
            outline: none;
            color: var(--text-color);
            padding: 5px;
            width: 120px;
        }

        .search-bar button {
            background: none;
            border: none;
            color: var(--text-color);
            cursor: pointer;
        }

        .user-icon i {
            font-size: 1.8em;
            color: var(--text-color);
        }

        .header {
            width: 100%;
            background-color: rgba(0, 0, 0, 0.3);
            padding: 20px 30px;
            color: white;
            font-size: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            z-index: 1000;
        }

        .header a {
            color: #fff;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 8px;
            margin-left: 10px;
            transition: background 0.3s ease;
        }

        .header a:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        .form-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 120px;
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
        }

        h2 {
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
            color: #fff;
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

        @media (max-width: 600px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header a {
                margin-top: 10px;
                margin-left: 0;
            }

            .form-wrapper {
                padding: 100px 15px 30px;
            }
        }
    </style>
</head>
<body>

<!-- ✅ Imran Travels Style Menu -->
<header class="main-header">
        <div class="container">
            <div class="logo">
                <a href="#">Imran Travels</a>
            </div>
            <nav class="main-nav">
                <ul class="nav-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Groups</a></li>
                    <li><a href="#">Chats</a></li>
                    <li><a href="#">Register</a></li>
                    <li><a href="#">Destinations</a></li>
                    <li><a href="#">Packages</a></li>
                </ul>
            </nav>
            <div class="nav-controls">
                <div class="search-bar">
                    <input type="text" placeholder="Search...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
                <div class="user-icon">
                    <i class="fas fa-user-circle"></i>
                </div>
            </div>
        </div>
    </header>

<!-- Login Form Section -->
<div class="form-wrapper">
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

        <form method="POST">
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
</div>

</body>
</html>
