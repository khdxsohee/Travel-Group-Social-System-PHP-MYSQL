<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header('Location: groups.php');
    exit();
}

$group_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Check if already requested
$already = $conn->query("SELECT * FROM group_requests WHERE group_id = $group_id AND user_id = $user_id");

if ($already->num_rows == 0) {
    $conn->query("INSERT INTO group_requests (group_id, user_id) VALUES ($group_id, $user_id)");
    $_SESSION['success'] = "Request to join group sent successfully!";
} else {
    $_SESSION['success'] = "You have already requested to join this group.";
}

header('Location: groups.php');
exit();
?>
