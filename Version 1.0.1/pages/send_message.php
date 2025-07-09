<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_id = $_POST['group_id'];
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];

    // Insert message into chat_messages table
    $stmt = $conn->prepare("INSERT INTO chat_messages (group_id, user_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $group_id, $user_id, $message);
    $stmt->execute();

    // Redirect back to the group page
    header("Location: view_group.php?id=$group_id");
    exit();
}
?>
