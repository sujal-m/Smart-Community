<?php
session_start();
require_once 'db_config.php';
header('Content-Type: application/json');

// ✅ Check user session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to book a service.']);
    exit;
}

// ✅ Decode incoming JSON
$input = json_decode(file_get_contents("php://input"), true);
if (!$input) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$pro_id = null; // Not yet assigned
$service = $input['service'] ?? '';
$booking_datetime = $input['booking_datetime'] ?? '';
$address = $input['address'] ?? '';
$phone = $input['phone'] ?? '';
$cost = $input['cost'] ?? '';
$status = 'pending';
$created_at = date('Y-m-d H:i:s');
$updated_at = $created_at;

// ✅ Validate inputs
if (empty($service) || empty($booking_datetime) || empty($address) || empty($phone) || empty($cost)) {
    echo json_encode(['success' => false, 'message' => 'Please fill all required fields.']);
    exit;
}

// ✅ Prepare & insert
$stmt = $conn->prepare("
    INSERT INTO orders (user_id, pro_id, service, booking_datetime, address, phone, cost, status, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param("iissssdsss",
    $user_id,
    $pro_id,
    $service,
    $booking_datetime,
    $address,
    $phone,
    $cost,
    $status,
    $created_at,
    $updated_at
);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>
