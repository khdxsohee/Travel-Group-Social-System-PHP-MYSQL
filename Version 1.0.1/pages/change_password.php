<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['submit'])) {
    $old_password = md5($_POST['old_password']);
    $new_password = md5($_POST['new_password']);
    $user_id = $_SESSION['user_id'];

    $check = $conn->query("SELECT * FROM users WHERE id = $user_id AND password = '$old_password'");

    if ($check->num_rows > 0) {
        $conn->query("UPDATE users SET password = '$new_password' WHERE id = $user_id");
        $success = "Password changed successfully!";
    } else {
        $error = "Old password is incorrect!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="header">
    Change Password
    <a href="home.php" style="float:right; color: #fff;">Home</a>
</div>

<div class="container">
    <div class="card">
        <h2>Change Your Password</h2>

        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="POST">
            <input type="password" name="old_password" placeholder="Old Password" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="submit" name="submit" value="Change Password" class="btn">
        </form>

    </div>
</div>

</body>
</html>
