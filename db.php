<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "127.0.0.1"; // or "localhost"
$user = "root";
$pass = "";
$db_name = "tychokdb";
$port = 3307; // ⚠️ Use 3307 if your MySQL runs on this port

try {
    $conn = new mysqli($host, $user, $pass, $db_name, $port);
    // Optional: $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    // Stop script and display error
    die("Connection failed: " . $e->getMessage());
}
?>
