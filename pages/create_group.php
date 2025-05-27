<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['submit'])) {
    $group_name = $_POST['group_name'];
    $group_description = $_POST['group_description'];
    $group_type = $_POST['group_type'];
    $user_id = $_SESSION['user_id'];

    if (empty($group_name) || empty($group_description)) {
        $error = "All fields are required!";
    } else {
        $query = "INSERT INTO groups (group_name, description, group_type, created_by) 
                  VALUES ('$group_name', '$group_description', '$group_type', '$user_id')";
        if ($conn->query($query)) {
            header('Location: groups.php');
            exit();
        } else {
            $error = "There was an error creating the group.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Group</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #FFDEE9, #B5FFFC);
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header {
            width: 100%;
            background-color: rgba(0, 0, 0, 0.3);
            padding: 20px 30px;
            color: white;
            font-size: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header a {
            color: #fff;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .header a:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        .container {
            margin-top: 50px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 40px 30px;
            width: 90%;
            max-width: 500px;
            color: white;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color:rgb(172, 171, 171);
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
        }

        textarea {
            resize: vertical;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: white;
            color: #333;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #f0f0f0;
        }

        .error {
            background: rgba(255, 0, 0, 0.2);
            padding: 10px;
            border-radius: 6px;
            color: red;
            margin-bottom: 10px;
        }

        .success {
            background: rgba(0, 255, 0, 0.2);
            padding: 10px;
            border-radius: 6px;
            color: green;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="header">
    <span>Create a Group</span>
    <a href="home.php">Home</a>
</div>

<div class="container">
    <div class="card">
        <h2>Create New Group</h2>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>

        <form method="POST">
            <input type="text" name="group_name" placeholder="Group Name" required>
            <textarea name="group_description" placeholder="Group Description" rows="4" required></textarea>
            <select name="group_type">
                <option value="Public">Public</option>
                <option value="Private">Private</option>
            </select>
            <input type="submit" name="submit" value="Create Group" class="btn">
        </form>
    </div>
</div>

</body>
</html>
