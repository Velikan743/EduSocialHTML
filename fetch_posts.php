<?php
$conn = new mysqli("localhost", "root", "", "edusocialnew");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC");

$posts = array();
while ($row = $result->fetch_assoc()) {
    $row['filepath'] = "uploads/" . $row['filename']; // Ensure correct file path
    $posts[] = $row;
}

echo json_encode($posts);

$conn->close();
?>
