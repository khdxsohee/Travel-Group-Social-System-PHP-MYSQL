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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #007bff;
            --text-color: #fff;
            --section-bg-dark: rgba(0, 0, 0, 0.6);
            --form-input-bg: rgba(255, 255, 255, 0.1);
        }

        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            color: var(--text-color);
            background-image: url('../bc.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .main-header {
    width: 100%;
    padding: 20px 0;
    background-color: rgba(0, 0, 0, 0.6);
    position: fixed;
    top: 0;
    z-index: 1000;
    
}

.main-header .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
}

.logo a {
    color: var(--text-color);
    text-decoration: none;
    font-size: 1.8em;
    font-weight: 700;
}

.main-nav .nav-links {
    list-style: none;
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding-left: 0;
    margin: 10px 0;
}

.main-nav .nav-links a {
    color: var(--text-color);
    text-decoration: none;
    font-size: 1em;
    font-weight: 600;
    transition: color 0.3s ease;
}

.main-nav .nav-links a:hover {
    color: var(--primary-color);
}

.nav-controls {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

.search-bar {
    display: flex;
    align-items: center;
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 25px;
    padding: 5px 15px;
}

.search-bar input {
    background: none;
    border: none;
    outline: none;
    color: var(--text-color);
    padding: 0px;
    width: 120px;
}

.search-bar button {
    background: none;
    border: none;
    color: var(--text-color);
    cursor: pointer;
}

.user-icon i {
    font-size: 1.8em;
    color: var(--text-color);
}


        .internal-header {
            padding: 15px 20px;
            background-color: rgba(0, 0, 0, 0.4);
            margin-top: 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .internal-header a {
            color: var(--text-color);
            text-decoration: none;
            background: rgba(255, 255, 255, 0.1);
            padding: 6px 12px;
            border-radius: 6px;
            margin-left: 10px;
        }

        .container {
            max-width: 500px;
            margin: 60px auto 40px;
            background: var(--section-bg-dark);
            border-radius: 16px;
            padding: 40px 30px;
            color: var(--text-color);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
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
            background: var(--form-input-bg);
            color: var(--text-color);
        }

        textarea {
            resize: vertical;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: var(--primary-color);
            color: var(--text-color);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #0056b3;
        }

        .error, .success {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
        }

        .error {
            background: rgba(255, 0, 0, 0.2);
            color: red;
        }

        .success {
            background: rgba(0, 255, 0, 0.2);
            color: green;
        }

        @media (max-width: 600px) {
            .container {
                width: 90%;
                margin-top: 100px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<!-- ✅ Top Navigation -->
<header class="main-header">
    <div class="container">
        <div class="logo">
            <a href="#">Imran Travels</a>
        </div>
        <nav class="main-nav">
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="groups.php">Groups</a></li>
                <li><a href="#">Chats</a></li>
                <li><a href="#">Register</a></li>
                <li><a href="#">Destinations</a></li>
                <li><a href="#">Packages</a></li>
            </ul>
        </nav>
        <div class="nav-controls">
            
            <div class="user-icon">
                <i class="fas fa-user-circle"></i>
            </div>
        </div>
    </div>
</header>

<!-- ✅ Internal Header -->
<div class="internal-header">
    <div>
        Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
    </div>
    <div>
        <a href="requests.php">Join Requests</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<!-- ✅ Group Creation Form -->
<div class="container">
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

</body>
</html>
