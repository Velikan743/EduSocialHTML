<?php
$conn = new mysqli("localhost", "root", "", "edusocialnew");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT messages.*, users.username FROM messages JOIN users ON messages.user_id = users.id ORDER BY messages.created_at ASC");

$messages = array();
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);

$conn->close();
?>
