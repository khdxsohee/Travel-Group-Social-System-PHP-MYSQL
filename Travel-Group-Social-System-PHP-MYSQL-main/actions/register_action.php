<?php
session_start();
include('../config/db.php');

if(isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Travel Group Social System</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php
session_start();
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($check->num_rows > 0) {
        $_SESSION['error'] = "Email already registered.";
        header('Location: ../pages/register.php');
    } else {
        $insert = $conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')");
        if ($insert) {
            $_SESSION['success'] = "Registration successful! Please login.";
            header('Location: ../pages/login.php');
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again.";
            header('Location: ../pages/register.php');
        }
    }
} else {
    header('Location: ../pages/register.php');
}
?>

