<?php
session_start();
session_unset(); // Clear all session variables
session_destroy(); // Destroy the session

// Optional: add a custom alert
session_start(); // Start session again for alert
$_SESSION['alert'] = "You have been logged out.";
$_SESSION['redirect_after_alert'] = "index.php";

// Redirect back to homepage
header("Location: index.php");
exit();
?>
