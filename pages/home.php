<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Travel Group Social System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
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
            position: relative;
        }

        .header a {
            color: #fff;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 8px;
            margin-left: 10px;
            transition: background 0.3s ease;
        }

        .header a:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        .container {
            margin-top: 60px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 40px 30px;
            width: 90%;
            max-width: 450px;
            text-align: center;
            color: white;
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card h2 {
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            margin: 10px 5px;
            padding: 12px 20px;
            background: white;
            color: #333;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #f0f0f0;
        }
    </style>
</head>
<body>

<div class="header">
    <div>
        Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
    </div>
    <div>
        <a href="requests.php">Join Requests</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <div class="card">
        <h2>Dashboard</h2>
        <p>What would you like to do?</p>
        <a href="create_group.php" class="btn">Create New Group</a>
        <a href="groups.php" class="btn">View Travel Groups</a>
    </div>
</div>

</body>
</html>
