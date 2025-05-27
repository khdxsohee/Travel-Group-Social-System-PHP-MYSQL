<?php
// Redirect user to login page if not logged in
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: pages/login.php');
    exit();
} else {
    // Redirect to home if already logged in
    header('Location: pages/home.php');
    exit();
}
