<?php
session_start();
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($query->num_rows == 1) {
        $user = $query->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header('Location: ../pages/home.php');
        } else {
            $_SESSION['error'] = "Incorrect Password.";
            header('Location: ../pages/login.php');
        }
    } else {
        $_SESSION['error'] = "Email not found.";
        header('Location: ../pages/login.php');
    }
} else {
    header('Location: ../pages/login.php');
}
?>
