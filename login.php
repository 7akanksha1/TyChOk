<?php
session_start();
require 'db.php'; // adjust this to your DB connection script

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute SQL to fetch user by username
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $user = $result->fetch_assoc()) {
        // Verify password (assuming passwords are hashed)
        if (password_verify($password, $user['password'])) {
            // ✅ Set session after successful login
            $_SESSION['user'] = [
                'username' => $user['username'],
                'email' => $user['email']
            ];

            // Optional: set a custom alert for successful login
            $_SESSION['alert'] = "Login successful!";
            $_SESSION['redirect_after_alert'] = "index.php";

            header("Location: index.php");
            exit();
        } else {
            $_SESSION['alert'] = "Incorrect password.";
            $_SESSION['redirect_after_alert'] = "index.php";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['alert'] = "User not found.";
        $_SESSION['redirect_after_alert'] = "index.php";
        header("Location: index.php");
        exit();
    }
}
?>
