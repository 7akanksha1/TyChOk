<?php
session_start();
require 'db.php'; // Your DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Check if user already exists
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['alert'] = "Username or Email already exists!";
        $_SESSION['redirect_after_alert'] = "index.php";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        
        if ($stmt->execute()) {
            // Set full user session
            $_SESSION['user'] = [
                'username' => $username,
                'email' => $email
            ];
            $_SESSION['alert'] = "Sign up successful! Welcome, $username";
            $_SESSION['redirect_after_alert'] = "index.php";
        } else {
            $_SESSION['alert'] = "Sign up failed. Please try again.";
            $_SESSION['redirect_after_alert'] = "index.php";
        }
    }

    header("Location: index.php");
    exit();
}
?>
