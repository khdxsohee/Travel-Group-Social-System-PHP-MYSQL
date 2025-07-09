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

$user_id = $_SESSION['user_id'];
$groups = $conn->query("SELECT * FROM groups ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Groups - Travel Group Social System</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #007bff;
            --text-color: #fff;
            --section-bg-dark: rgba(0, 0, 0, 0.6);
            --form-input-bg: rgba(255, 255, 255, 0.1);
            --form-input-border: rgba(255, 255, 255, 0.3);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            color: var(--text-color);
            background-image: url('../bc.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* Navigation Bar */
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

        /* Internal Header */
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

        /* Container + Table */
        .container {
            margin: 50px auto;
            max-width: 1000px;
            background: var(--section-bg-dark);
            border-radius: 16px;
            padding: 40px;
            color: var(--text-color);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        h2 {
            text-align: center;
            font-size: 2.5em;
            font-weight: 700;
            margin-bottom: 30px;
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
            font-weight: 600;
            font-size: 1.1em;
        }

        tr:nth-child(even) {
            background-color: var(--form-input-bg);
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .btn {
            display: inline-block;
            padding: 10px 25px;
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
            margin-top: 20px;
        }

        p[style*="color:lightgreen"] {
            color: #8aff8a !important;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .main-header .container {
                flex-direction: column;
                text-align: center;
            }

            .nav-controls {
                margin-top: 15px;
            }

            .container {
                margin: 30px 15px;
                padding: 25px;
            }

            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr {
                display: none;
            }

            td {
                position: relative;
                padding-left: 50%;
                margin-bottom: 10px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                text-align: right;
            }

            td:before {
                position: absolute;
                top: 15px;
                left: 15px;
                font-weight: bold;
                content: attr(data-label);
                color: rgba(255, 255, 255, 0.7);
                text-align: left;
            }

            .btn {
                width: 100%;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

<!-- ✅ Navigation -->
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

<!-- ✅ Main Content -->
<div class="container">
    <h2>Travel Groups</h2>

    <?php
    if (isset($_SESSION['success'])) {
        echo '<p style="color:lightgreen;">'.$_SESSION['success'].'</p>';
        unset($_SESSION['success']);
    }
    ?>

    <?php if ($groups->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Group Name</th>
                    <th>Visibility</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php while($group = $groups->fetch_assoc()): ?>
                <tr>
                    <td data-label="Group Name"><?php echo htmlspecialchars($group['group_name']); ?></td>
                    <td data-label="Visibility"><?php echo ucfirst($group['group_type']); ?></td>
                    <td data-label="Action">
                        <?php
                        $group_id = $group['id'];

                        $check_member_query = "SELECT * FROM group_members WHERE group_id = ? AND user_id = ? AND status = 'approved'";
                        $stmt = $conn->prepare($check_member_query);
                        $stmt->bind_param("ii", $group_id, $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        $check_request_query = "SELECT * FROM group_requests WHERE group_id = ? AND user_id = ? AND status = 'pending'";
                        $stmt2 = $conn->prepare($check_request_query);
                        $stmt2->bind_param("ii", $group_id, $user_id);
                        $stmt2->execute();
                        $result2 = $stmt2->get_result();

                        if ($result->num_rows > 0) {
                            echo '<a href="view_group.php?id='.$group_id.'" class="btn">View Group</a>';
                        } elseif ($result2->num_rows > 0) {
                            echo '<span style="color: rgba(255, 255, 255, 0.7); font-weight: 500;">Request Pending</span>';
                        } else {
                            if ($group['group_type'] == 'Public') {
                                echo '<a href="view_group.php?id='.$group_id.'" class="btn">View Group</a>';
                            } else {
                                echo '<a href="request_join.php?id='.$group_id.'" class="btn">Request to Join</a>';
                            }
                        }
                        ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No groups available yet.</p>
    <?php endif; ?>
</div>

</body>
</html>
