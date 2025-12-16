<?php
require 'db_config.php';
session_start();

if (!isset($_SESSION['pro_id'])) {
    header("Location: pro_login.php");
    exit();
}

$pro_id = $_SESSION['pro_id'];

/* ===== Fetch professional ===== */
$stmt = $conn->prepare("SELECT full_name, email, phone FROM professional WHERE pro_id = ?");
$stmt->bind_param("i", $pro_id);
$stmt->execute();
$pro = $stmt->get_result()->fetch_assoc();

/* ===== Handle Society Request ===== */
if (isset($_POST['request_society'])) {
    $admin_id = intval($_POST['admin_id']);

    $req = $conn->prepare("
        INSERT INTO admin_professional (admin_id, pro_id, status)
        VALUES (?, ?, 'pending')
        ON DUPLICATE KEY UPDATE status='pending'
    ");
    $req->bind_param("ii", $admin_id, $pro_id);
    $req->execute();

    header("Location: pro_dashboard.php");
    exit();
}

/* ===== Handle Order Actions ===== */
if (isset($_POST['order_action'])) {
    $order_id = intval($_POST['order_id']);

    if ($_POST['order_action'] === 'accept') {
        $stmt = $conn->prepare(
            "UPDATE orders SET pro_id=?, status='accepted' WHERE order_id=?"
        );
        $stmt->bind_param("ii", $pro_id, $order_id);
        $stmt->execute();
    }

    if ($_POST['order_action'] === 'reject') {
        $stmt = $conn->prepare(
            "UPDATE orders SET status='rejected' WHERE order_id=?"
        );
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
    }

    if ($_POST['order_action'] === 'complete') {
        $stmt = $conn->prepare(
            "UPDATE orders SET status='completed' WHERE order_id=? AND pro_id=?"
        );
        $stmt->bind_param("ii", $order_id, $pro_id);
        $stmt->execute();
    }

    header("Location: pro_dashboard.php");
    exit();
}

$statusStmt = $conn->prepare("
    SELECT a.admin_name, ap.status
    FROM admin_professional ap
    JOIN admin a ON ap.admin_id = a.admin_id
    WHERE ap.pro_id = ?
");
$statusStmt->bind_param("i", $pro_id);
$statusStmt->execute();
$society_requests = $statusStmt->get_result();

$approved_check = $conn->query("
    SELECT 1 
    FROM admin_professional 
    WHERE pro_id = $pro_id AND status = 'approved'
    LIMIT 1
");
$can_view_orders = ($approved_check->num_rows > 0);

/* ===== Orders ===== */
if ($can_view_orders) {
    $new_orders = $conn->query("
        SELECT * FROM orders 
        WHERE pro_id IS NULL AND status='pending'
    ");
}

$my_orders = $conn->prepare("SELECT * FROM orders WHERE pro_id=?");
$my_orders->bind_param("i", $pro_id);
$my_orders->execute();
$my_orders_result = $my_orders->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Professional Dashboard | HomEase</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
body{background:#f4f6f8}
.dashboard-section{padding:50px}
.dashboard-container{max-width:1200px;margin:auto}
.dashboard-grid{display:grid;grid-template-columns:1fr 2fr;gap:25px}
.dashboard-card{background:#fff;border-radius:12px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.08)}
.orders-table{width:100%;border-collapse:collapse}
.orders-table th{background:#ff6600;color:#fff;padding:10px}
.orders-table td{padding:10px;border-bottom:1px solid #ddd}
.btn{padding:6px 14px;border:none;border-radius:6px;font-weight:600;cursor:pointer}
.accept{background:#28a745;color:#fff}
.reject{background:#dc3545;color:#fff}
.complete{background:#007bff;color:#fff}
</style>
</head>
<body>

<header class="navbar">
  <div class="navbar-content">
    <div class="logo"><img src="../assets/images/logo.png"></div>
    <div class="navbar-right">
      <a href="pro_login.php?logout=true" class="cta-btn">Logout</a>
    </div>
  </div>
</header>

<section class="dashboard-section">
<div class="dashboard-container">
<h2>Welcome, <?= htmlspecialchars($pro['full_name']) ?> 👷‍♂️</h2>

<div class="dashboard-grid">

<!-- PROFILE + SOCIETY -->
<div class="dashboard-card">
<h3>Your Profile</h3>
<p><b>Email:</b> <?= htmlspecialchars($pro['email']) ?></p>
<p><b>Phone:</b> <?= htmlspecialchars($pro['phone']) ?></p>

<hr>

<h3>Select Society</h3>
<form method="POST">
<select name="admin_id" required>
<option value="">Select Society</option>
<?php
$socs = mysqli_query($conn, "SELECT admin_id, admin_name FROM admin");
while ($s = mysqli_fetch_assoc($socs)) {
    echo "<option value='{$s['admin_id']}'>{$s['admin_name']}</option>";
}
?>
</select>
<button type="submit" name="request_society" class="cta-btn" style="margin-top:10px">
Request Access
</button>
</form>

<hr>

<h3>Your Requests</h3>
<ul>
<?php while ($r = $society_requests->fetch_assoc()): ?>
<li>
<?= htmlspecialchars($r['admin_name']) ?> —
<b><?= ucfirst($r['status']) ?></b>
</li>
<?php endwhile ?>
</ul>

<a href="pro_profile.php" class="cta-btn" style="margin-top:10px">Edit Profile</a>
</div>

<!-- ORDERS -->
<div class="dashboard-card">

<h3>🆕 New Orders</h3>
<?php if ($can_view_orders && $new_orders->num_rows): ?>
<table class="orders-table">
<tr><th>Service</th><th>Address</th><th>Cost</th><th>Action</th></tr>
<?php while($o = $new_orders->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($o['service']) ?></td>
<td><?= htmlspecialchars($o['address']) ?></td>
<td>₹<?= htmlspecialchars($o['cost']) ?></td>
<td>
<form method="POST" style="display:inline">
<input type="hidden" name="order_id" value="<?= $o['order_id'] ?>">
<button class="btn accept" name="order_action" value="accept">Accept</button>
</form>
<form method="POST" style="display:inline">
<input type="hidden" name="order_id" value="<?= $o['order_id'] ?>">
<button class="btn reject" name="order_action" value="reject">Reject</button>
</form>
</td>
</tr>
<?php endwhile ?>
</table>
<?php else: ?>
<p>
<?php if (!$can_view_orders): ?>
    Your request to work in a society is not approved yet.
<?php else: ?>
    No new orders.
<?php endif; ?>
</p>
<?php endif ?>

<hr style="margin:30px 0">

<h3>🧾 Your Jobs</h3>
<?php if ($my_orders_result->num_rows): ?>
<table class="orders-table">
<tr><th>Service</th><th>Status</th><th>Action</th></tr>
<?php while($j = $my_orders_result->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($j['service']) ?></td>
<td><?= ucfirst($j['status']) ?></td>
<td>
<?php if ($j['status'] === 'accepted'): ?>
<form method="POST">
<input type="hidden" name="order_id" value="<?= $j['order_id'] ?>">
<button class="btn complete" name="order_action" value="complete">
Mark Completed
</button>
</form>
<?php else: ?> — <?php endif ?>
</td>
</tr>
<?php endwhile ?>
</table>
<?php else: ?>
<p>No active jobs</p>
<?php endif ?>

</div>
</div>
</div>
</section>

<footer class="footer">
<p style="text-align:center">&copy; 2025 HomEase</p>
</footer>

</body>
</html>
