<?php
require 'db_config.php';
session_start();

if (!isset($_SESSION['pro_id'])) {
    header("Location: pro_login.php");
    exit();
}

$pro_id = $_SESSION['pro_id'];

/* ===== Fetch profile + society ===== */
$res = $conn->query("
    SELECT p.*, a.admin_name AS society
    FROM professional p
    LEFT JOIN admin_professional ap ON p.pro_id = ap.pro_id
    LEFT JOIN admin a ON ap.admin_id = a.admin_id
    WHERE p.pro_id = $pro_id
");
$pro = $res->fetch_assoc();

/* ===== Update profile ===== */
if (isset($_POST['update_profile'])) {
    $name  = $_POST['full_name'];
    $phone = $_POST['phone'];
    mysqli_query(
        $conn,
        "UPDATE professional SET full_name='$name', phone='$phone' WHERE pro_id=$pro_id"
    );
    header("Location: pro_profile.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Profile</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h2>Manage Profile</h2>

<form method="POST">
<input type="text" name="full_name" value="<?= htmlspecialchars($pro['full_name']); ?>" required>
<input type="email" value="<?= htmlspecialchars($pro['email']); ?>" readonly>
<input type="text" name="phone" value="<?= htmlspecialchars($pro['phone']); ?>" required>
<input type="text" value="<?= htmlspecialchars($pro['society']); ?>" readonly>
<button name="update_profile" class="cta-btn">Update</button>
</form>

<a href="pro_dashboard.php" class="cta-btn">Back to Dashboard</a>

</body>
</html>
