<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'None'
]);
session_start();

include('../config/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Travel Group Social System</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Include all your previous styles here, then add these for the menu: */
        :root {
            --primary-color: #007bff;
            --text-color: #fff;
            --section-bg-dark: rgba(0, 0, 0, 0.6);
        }

        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            color: var(--text-color);
            background: transparent;
        }

        .main-header {
            width: 100%;
            padding: 20px 0;
            background-color: rgba(0, 0, 0, 0.6);
            position: relative;
            top: 0;
            z-index: 100;
        }

        .main-header .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
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
            gap: 30px;
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
            gap: 20px;
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
            padding: 5px;
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

        /* Add your existing .internal-header, .dashboard-container etc. styles here */

        .internal-header {
            padding: 15px 20px;
            background-color: rgba(0, 0, 0, 0.4);
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

        .dashboard-container {
            margin: 100px auto;
            max-width: 500px;
            background: var(--section-bg-dark);
            border-radius: 16px;
            padding: 40px;
            text-align: center;
        }

        .btn {
            display: inline-block;
            margin: 10px 5px;
            padding: 12px 20px;
            background: var(--primary-color);
            color: var(--text-color);
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <!-- ✅ Navigation Menu (Imran Travels Style) -->
    <header class="main-header">
        <div class="container">
            <div class="logo">
                <a href="#">Imran Travels</a>
            </div>
            <nav class="main-nav">
                <ul class="nav-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Groups</a></li>
                    <li><a href="#">Chats</a></li>
                    <li><a href="#">Register</a></li>
                    <li><a href="#">Destinations</a></li>
                    <li><a href="#">Packages</a></li>
                </ul>
            </nav>
            <div class="nav-controls">
                <div class="search-bar">
                    <input type="text" placeholder="Search...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
                <div class="user-icon">
                    <i class="fas fa-user-circle"></i>
                </div>
            </div>
        </div>
    </header>

    <!-- ✅ Internal Header for Auth Info -->
    <div class="internal-header">
        <div>
            Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
        </div>
        <div>
            <a href="requests.php">Join Requests</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>

    <!-- ✅ Main Dashboard Content -->
    <div class="dashboard-container">
        <h2>Dashboard</h2>
        <p>What would you like to do?</p>
        <a href="create_group.php" class="btn">Create New Group</a>
        <a href="groups.php" class="btn">View Travel Groups</a>
    </div>

</body>
</html>
