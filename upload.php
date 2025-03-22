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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $filename = basename($_FILES["file"]["name"]);
    $filetype = $_FILES["file"]["type"];
    $target_file = $target_dir . $filename;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO posts (user_id, filename, filetype, filepath) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $filename, $filetype, $target_file);
        $stmt->execute();
        echo "File uploaded successfully.";
    } else {
        echo "Error uploading file.";
    }
}

$conn->close();
?>
