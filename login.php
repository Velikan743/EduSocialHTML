<?php
session_start();
$conn = new mysqli("localhost", "root", "", "edusocialnew");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $user_id;
            $_SESSION["username"] = $username;
            header("Location: index.html");
            exit();
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href='login.html';</script>";
    }
    
    $stmt->close();
}

$conn->close();
?>
