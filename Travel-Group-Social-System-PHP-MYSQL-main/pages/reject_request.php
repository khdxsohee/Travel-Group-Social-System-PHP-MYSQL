<?php
session_start();
include('../config/db.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Ensure the request ID is provided
if (isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];

    // Update the status of the join request to 'rejected'
    $update_request = "UPDATE group_requests SET status = 'rejected' WHERE id = ?";
    $stmt = $conn->prepare($update_request);
    $stmt->bind_param("i", $request_id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Request rejected!";
    } else {
        $_SESSION['error'] = "Failed to reject request!";
    }
} else {
    $_SESSION['error'] = "Invalid request.";
}

header('Location: requests.php');
exit();
?>
