<?php
// Redirect user to login page if not logged in
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit();
} else {
    // Redirect to home if already logged in
    header('Location: index.html');
    exit();
}
