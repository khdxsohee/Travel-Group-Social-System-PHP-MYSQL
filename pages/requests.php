<?php
session_start();
include('../config/db.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch all pending join requests
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
            justify-content: center;
            align-items: center;
            color: white;
        }

        .header {
            width: 100%;
            background: rgba(0, 0, 0, 0.4);
            padding: 20px 30px;
            color: white;
            font-size: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
        }

        .header a {
            color: white;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px 20px;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .header a:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        .container {
            margin-top: 80px;
            width: 90%;
            max-width: 1000px;
            background: rgba(241, 47, 47, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            font-size: 32px;
            margin-bottom: 20px;
            font-weight: bold;
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
            border-radius: 6px;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .btn {
            padding: 8px 16px;
            background-color: #fff;
            color: #333;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.3s ease;
            margin-right: 10px;
        }

        .btn:hover {
            background-color: #f1f1f1;
        }

        p {
            font-size: 18px;
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
    Join Requests
    <div>
        <a href="home.php" class="btn">Home</a>
        <a href="../logout.php" class="btn">Logout</a>
    </div>
</div>

<div class="container">
    <div class="card">
        <h2>Pending Join Requests</h2>
        
        <?php
        if (isset($_SESSION['success'])) {
            echo '<p style="color:green;">'.$_SESSION['success'].'</p>';
            unset($_SESSION['success']);
        }
        
        if (isset($_SESSION['error'])) {
            echo '<p style="color:red;">'.$_SESSION['error'].'</p>';
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
                    <?php while($request = $requests->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($request['group_name']); ?></td>
                            <td><?php echo htmlspecialchars($request['user_name']); ?></td>
                            <td>
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
</div>

</body>
</html>
