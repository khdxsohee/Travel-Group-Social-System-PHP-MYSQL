<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$query = "SELECT group_requests.id, groups.group_name, users.name AS user_name, group_requests.status 
          FROM group_requests
          JOIN groups ON group_requests.group_id = groups.id
          JOIN users ON group_requests.user_id = users.id
          WHERE group_requests.status = 'pending'";
$requests = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Join Requests - Travel Group Social System</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #007bff;
            --text-color: #fff;
            --section-bg-dark: rgba(0, 0, 0, 0.6);
            --form-input-bg: rgba(255, 255, 255, 0.1);
            --form-input-border: rgba(255, 255, 255, 0.3);
        }

        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            color: var(--text-color);
            background-image: url('../bc.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }

        /* === Main Navigation Header === */
        .main-header {
            width: 100%;
            padding: 20px 0;
            background-color: rgba(0, 0, 0, 0.6);
            position: fixed;
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
            margin: 40px auto;
            max-width: 1000px;
            background: var(--section-bg-dark);
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            color: var(--text-color);
        }

        h2 {
            text-align: center;
            font-size: 2.4em;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid var(--form-input-border);
        }

        th {
            background: rgba(255, 255, 255, 0.15);
        }

        tr:nth-child(even) {
            background-color: var(--form-input-bg);
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .btn {
            padding: 8px 18px;
            background-color: var(--primary-color);
            color: var(--text-color);
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        p {
            text-align: center;
            font-size: 1.1em;
            color: rgba(255, 255, 255, 0.9);
        }

        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr {
                display: none;
            }

            td {
                position: relative;
                padding-left: 50%;
                text-align: right;
                margin-bottom: 10px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            }

            td:before {
                position: absolute;
                top: 12px;
                left: 15px;
                font-weight: bold;
                content: attr(data-label);
                color: rgba(255, 255, 255, 0.7);
            }
        }
    </style>
</head>
<body>

<!-- ✅ Main Nav Menu (Like Home) -->
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

<!-- ✅ Internal User Header -->
<div class="internal-header">
    <div>
        Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
    </div>
    <div>
        <a href="requests.php">Join Requests</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<!-- ✅ Main Content Area -->
<div class="container">
    <h2>Pending Join Requests</h2>

    <?php
    if (isset($_SESSION['success'])) {
        echo '<p style="color:lightgreen;">' . $_SESSION['success'] . '</p>';
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red;">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    ?>

    <?php if ($requests->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Group Name</th>
                    <th>User Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($request = $requests->fetch_assoc()): ?>
                    <tr>
                        <td data-label="Group Name"><?php echo htmlspecialchars($request['group_name']); ?></td>
                        <td data-label="User Name"><?php echo htmlspecialchars($request['user_name']); ?></td>
                        <td data-label="Action">
                            <a href="accept_request.php?request_id=<?php echo $request['id']; ?>" class="btn">Accept</a>
                            <a href="reject_request.php?request_id=<?php echo $request['id']; ?>" class="btn">Reject</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No pending requests.</p>
    <?php endif; ?>
</div>

</body>
</html>
