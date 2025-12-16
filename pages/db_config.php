<?php
// Database configuration
$servername = "localhost";   // Usually localhost
$username = "root";          // Your MySQL username
$password = "";              // Your MySQL password
$database = "homease_db";    // Database name

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
