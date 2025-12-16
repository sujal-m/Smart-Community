<?php
require_once 'admin_auth.php';
require_once 'db_config.php';

$adminId = $_SESSION['admin_id'];
$proId = intval($_POST['pro_id']);
$action = $_POST['action'];

$status = $action === 'approve' ? 'approved' : 'rejected';

$stmt = $conn->prepare("
UPDATE admin_professional
SET status = ?
WHERE admin_id = ? AND pro_id = ?
");
$stmt->bind_param("sii",$status,$adminId,$proId);
$stmt->execute();

header("Location: admin_dashboard.php");
exit();
