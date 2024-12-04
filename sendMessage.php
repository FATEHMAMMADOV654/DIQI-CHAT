<?php
include 'db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id'])) {
        $sender_id = $_SESSION['user_id'];
        $receiverUsername = $_POST['receiverUsername'];
        $message = $_POST['message'];

        // Get receiver_id
        $sql = "SELECT id FROM users WHERE username='$receiverUsername'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $receiver_id = $row['id'];

            // Insert message into messages table
            $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$sender_id', '$receiver_id', '$message')";
            if ($conn->query($sql) === TRUE) {
                echo "Message sent!";
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Receiver not found!";
        }
    } else {
        echo "You must be logged in to send a message!";
    }
}
?>
