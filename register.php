<?php
$conn = new mysqli("localhost", "root", "", "edusocialnew");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = password_hash(trim($_POST["password"]), PASSWORD_BCRYPT);

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Please login.'); window.location.href='login.html';</script>";
        } else {
            echo "<script>alert('Username already taken!'); window.location.href='register.html';</script>";
        }
        
        $stmt->close();
    }
}

$conn->close();
?>
