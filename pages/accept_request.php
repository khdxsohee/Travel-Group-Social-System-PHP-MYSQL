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

    // Fetch request details
    $query = "SELECT * FROM group_requests WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the request exists
    if ($result->num_rows > 0) {
        $request = $result->fetch_assoc();
        $group_id = $request['group_id'];
        $user_id = $request['user_id'];

        // Update the status of the join request to 'accepted'
        $update_request = "UPDATE group_requests SET status = 'accepted' WHERE id = ?";
        $stmt = $conn->prepare($update_request);
        $stmt->bind_param("i", $request_id);
        if ($stmt->execute()) {
            // Add user to the group as an 'approved' member
            $insert_member = "INSERT INTO group_members (group_id, user_id, status) VALUES (?, ?, 'approved')";
            $stmt = $conn->prepare($insert_member);
            $stmt->bind_param("ii", $group_id, $user_id);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Request accepted and user added to the group!";
            } else {
                $_SESSION['error'] = "Failed to add user to the group.";
            }
        } else {
            $_SESSION['error'] = "Failed to accept request!";
        }
    } else {
        $_SESSION['error'] = "Request not found!";
    }
} else {
    $_SESSION['error'] = "Invalid request.";
}

header('Location: requests.php');
exit();
?>
