<?php
session_start();
include('../config/db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Validate group_id
$group_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($group_id <= 0) {
    echo "Invalid group ID.";
    exit();
}

// Fetch group details securely
$stmt = $conn->prepare("SELECT * FROM groups WHERE id = ?");
$stmt->bind_param("i", $group_id);
$stmt->execute();
$group_result = $stmt->get_result();
$group = $group_result->fetch_assoc();
$stmt->close();

if (!$group) {
    echo "Group not found.";
    exit();
}

// Fetch messages
$messages_query = $conn->query("
    SELECT chat_messages.*, users.name AS user_name 
    FROM chat_messages 
    JOIN users ON chat_messages.user_id = users.id 
    WHERE group_id = $group_id 
    ORDER BY chat_messages.sent_at DESC
");

// Current user's ID
$current_user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($group['group_name']); ?> - Chat</title>
   
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
        }

        .header {
            background-color: #128c7e;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .chat-container {
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            height: 85vh;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            background-color: #f0f0f0;
        }

        .chat-box {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background-image: url('../images/chat-bg.png');
            background-size: cover;
            display: flex;
            flex-direction: column-reverse;
            
        }

        .chat-message {
            margin-bottom: 15px;
            max-width: 70%;
            padding: 10px;
            border-radius: 10px;
            word-wrap: break-word;
        }

        .chat-message.sent {
            background-color: #dcf8c6;
            align-self: flex-end;
            text-align: right;
        }

        .chat-message.received {
            background-color: #ffffff;
            align-self: flex-start;
            text-align: left;
        }

        .message-meta {
            font-size: 12px;
            color: #555;
            margin-bottom: 5px;
        }

        .message-content {
            font-size: 14px;
            color: #111;
        }

        .chat-form {
            display: flex;
            padding: 10px;
            background-color: #fff;
            border-top: 1px solid #ccc;
        }

        .chat-form textarea {
            flex: 1;
            resize: none;
            height: 40px;
            padding: 10px;
            font-size: 14px;
            border-radius: 30px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        .chat-form button {
            background-color: #128c7e;
            color: white;
            border: none;
            padding: 0 20px;
            font-size: 20px;
            border-radius: 50%;
            cursor: pointer;
        }

        .chat-form button:hover {
            background-color: #075e54;
        }

        .no-messages {
            text-align: center;
            color: #777;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="header">
    <a href="groups.php">⬅ Groups</a>
    <span><?php echo htmlspecialchars($group['group_name']); ?> Chat</span>
    <a href="home.php">Home</a>
</div>

<div class="chat-container">
    <div class="chat-box">
        <?php if ($messages_query->num_rows > 0): ?>
            <?php while ($message = $messages_query->fetch_assoc()): ?>
                <div class="chat-message <?php echo ($message['user_id'] == $current_user_id) ? 'sent' : 'received'; ?>">
                    <div class="message-meta">
                        <span class="sender"><?php echo htmlspecialchars($message['user_name']); ?></span>
                        <span class="timestamp"><?php echo $message['sent_at']; ?></span>
                    </div>
                    <div class="message-content">
                        <?php echo htmlspecialchars($message['message']); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-messages">No messages yet.</p>
        <?php endif; ?>
    </div>

    <form class="chat-form" action="send_message.php" method="POST">
        <input type="hidden" name="group_id" value="<?php echo $group_id; ?>">
        <textarea name="message" placeholder="Type a message..." required></textarea>
        <button type="submit">➤</button>
    </form>
</div>

</body>
</html>
