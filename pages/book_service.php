<?php
require 'db_config.php';
session_start();

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login to book a service.'); window.location.href='login.php';</script>";
    exit();
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $service = $_POST['service'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $cost = $_POST['cost'];

    // Optionally assign a professional (future logic)
    $pro_id = NULL;

    $stmt = $conn->prepare("INSERT INTO orders (user_id, service, date, time, address, full_name, phone, cost, pro_id) 
                            VALUES (?, ?, ?, ?, ?, 
                                    (SELECT full_name FROM users WHERE user_id = ?), ?, ?, ?)");
    $stmt->bind_param("issssissd", $user_id, $service, $date, $time, $address, $user_id, $phone, $cost, $pro_id);

    if ($stmt->execute()) {
        echo "<script>alert('Service booked successfully!'); window.location.href='user_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error booking service. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
}
$conn->close();
?>
