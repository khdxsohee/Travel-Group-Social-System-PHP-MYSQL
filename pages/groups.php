<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ffecd2, #fcb69f);
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
            margin-top: 40px;
            width: 90%;
            max-width: 1000px;
            background: rgba(54, 54, 54, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 30px;
            color: white;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            color: white;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background: rgba(255, 255, 255, 0.2);
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .btn {
            padding: 6px 12px;
            background-color: white;
            color: #333;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background-color: #f1f1f1;
        }

        p {
            text-align: center;
            font-size: 16px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px 10px;
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
            }

            td:before {
                position: absolute;
                top: 12px;
                left: 15px;
                font-weight: bold;
                content: attr(data-label);
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>

<div class="header">
    All Travel Groups
    <a href="home.php">Home</a>
</div>

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
                            echo 'Request Pending';
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
