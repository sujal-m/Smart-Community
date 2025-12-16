<?php
require_once 'admin_auth.php';
require_once 'db_config.php';

$adminId = $_SESSION['admin_id'];

/* COUNTS */
$user_count = $conn->query("
  SELECT COUNT(*) total
  FROM admin_users
  WHERE admin_id = $adminId
")->fetch_assoc()['total'];

$pro_count = $conn->query("
  SELECT COUNT(*) total
  FROM admin_professional
  WHERE admin_id = $adminId AND status = 'approved'
")->fetch_assoc()['total'];

$order_count = $conn->query("
  SELECT COUNT(*) total
  FROM orders o
  JOIN admin_users au ON au.user_id = o.user_id
  WHERE au.admin_id = $adminId
")->fetch_assoc()['total'];

/* DATA */
$users = $conn->prepare("
  SELECT u.*
  FROM users u
  JOIN admin_users au ON au.user_id = u.user_id
  WHERE au.admin_id = ?
  ORDER BY u.created_at DESC
");
$users->bind_param("i", $adminId);
$users->execute();
$users = $users->get_result();

$pendingPros = $conn->prepare("
  SELECT p.*
  FROM professional p
  JOIN admin_professional ap ON ap.pro_id = p.pro_id
  WHERE ap.admin_id = ? AND ap.status = 'pending'
");
$pendingPros->bind_param("i", $adminId);
$pendingPros->execute();
$pendingPros = $pendingPros->get_result();

$approvedPros = $conn->prepare("
  SELECT p.*
  FROM professional p
  JOIN admin_professional ap ON ap.pro_id = p.pro_id
  WHERE ap.admin_id = ? AND ap.status = 'approved'
");
$approvedPros->bind_param("i", $adminId);
$approvedPros->execute();
$approvedPros = $approvedPros->get_result();

$orders = $conn->prepare("
  SELECT o.*, u.full_name user_name, p.full_name pro_name
  FROM orders o
  JOIN admin_users au ON au.user_id = o.user_id
  JOIN users u ON u.user_id = o.user_id
  LEFT JOIN professional p ON p.pro_id = o.pro_id
  WHERE au.admin_id = ?
  ORDER BY o.created_at DESC
");
$orders->bind_param("i", $adminId);
$orders->execute();
$orders = $orders->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<style>
body{font-family:Poppins;background:#F6F5ED;margin:0}
.container{max-width:1200px;margin:30px auto}
.tabs button{padding:10px 20px;border:none;background:#ddd;cursor:pointer}
.tabs button.active{background:#FF6600;color:#fff}
.tab-content{display:none;background:#fff;padding:20px;border-radius:10px}
.card{background:#f9f9f9;padding:15px;border-radius:8px;margin-bottom:10px;display:flex;justify-content:space-between}
.btn{padding:6px 10px;border:none;border-radius:5px;cursor:pointer}
.approve{background:#28a745;color:#fff}
.reject{background:#dc3545;color:#fff}
.top-bar{display:flex;justify-content:space-between;align-items:center}
.stats span{margin-right:20px}
</style>
<script>
function openTab(id){
  document.querySelectorAll('.tab-content').forEach(t=>t.style.display='none');
  document.querySelectorAll('.tabs button').forEach(b=>b.classList.remove('active'));
  document.getElementById(id).style.display='block';
  document.getElementById(id+'Btn').classList.add('active');
}
window.onload=()=>openTab('residents');
</script>
</head>

<body>
<div class="container">

<div class="top-bar">
  <h2>Admin Dashboard</h2>
  <div>
    <a href="add_resident.php">➕ Add Resident</a> |
    <a href="admin_logout.php">Logout</a>
  </div>
</div>

<div class="stats">
  <span>👤 Residents: <?= $user_count ?></span>
  <span>🧰 Professionals: <?= $pro_count ?></span>
  <span>📦 Orders: <?= $order_count ?></span>
</div>

<div class="tabs">
  <button id="residentsBtn" onclick="openTab('residents')">Residents</button>
  <button id="prosBtn" onclick="openTab('pros')">Professionals</button>
  <button id="ordersBtn" onclick="openTab('orders')">Orders</button>
</div>

<!-- RESIDENTS -->
<div id="residents" class="tab-content">
<?php while($u=$users->fetch_assoc()): ?>
  <div class="card">
    <div>
      <b><?= $u['full_name'] ?></b><br>
      <?= $u['email'] ?> | <?= $u['phone'] ?>
    </div>
  </div>
<?php endwhile; ?>
</div>

<!-- PROFESSIONALS -->
<div id="pros" class="tab-content">
<h3>Pending Requests</h3>
<?php while($p=$pendingPros->fetch_assoc()): ?>
  <div class="card">
    <div><?= $p['full_name'] ?> (<?= $p['skill_type'] ?>)</div>
    <form method="POST" action="pro_action.php">
      <input type="hidden" name="pro_id" value="<?= $p['pro_id'] ?>">
      <button class="btn approve" name="action" value="approve">Approve</button>
      <button class="btn reject" name="action" value="reject">Reject</button>
    </form>
  </div>
<?php endwhile; ?>

<h3>Approved</h3>
<?php while($p=$approvedPros->fetch_assoc()): ?>
  <div class="card">
    <div><?= $p['full_name'] ?> (<?= $p['skill_type'] ?>)</div>
  </div>
<?php endwhile; ?>
</div>

<!-- ORDERS -->
<div id="orders" class="tab-content">
<?php while($o=$orders->fetch_assoc()): ?>
  <div class="card">
    <div>
      #<?= $o['order_id'] ?> – <?= $o['service'] ?><br>
      <?= $o['user_name'] ?> | <?= $o['pro_name'] ?? 'Unassigned' ?><br>
      ₹<?= $o['cost'] ?> | <?= ucfirst($o['status']) ?>
    </div>
  </div>
<?php endwhile; ?>
</div>

</div>
</body>
</html>
