<?php
session_start();
$conn = new mysqli("localhost", "root", "", "edusocialnew");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION["user_id"])) {
    die("User not logged in.");
}

$user_id = $_SESSION["user_id"];
$message = trim($_POST["message"]);

if (!empty($message)) {
    $stmt = $conn->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $message);
    $stmt->execute();
    echo "Message sent.";
} else {
    echo "Message cannot be empty.";
}

$conn->close();
?>
