<?php
require_once 'admin_auth.php';
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id'], $_POST['delete_type'])) {
  $id = intval($_POST['delete_id']);
  $type = $_POST['delete_type'];

  if ($type === 'user') {
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
  } elseif ($type === 'pro') {
    $stmt = $conn->prepare("DELETE FROM professional WHERE pro_id = ?");
  }

  if (isset($stmt)) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
  }

  header("Location: admin_dashboard.php");
  exit();
}

$user_count = $conn->query("SELECT COUNT(*) total FROM users")->fetch_assoc()['total'];
$pro_count = $conn->query("SELECT COUNT(*) total FROM professional")->fetch_assoc()['total'];
$order_count = $conn->query("SELECT COUNT(*) total FROM orders")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - HomEase</title>
  <style>
    body {
      font-family: Poppins;
      background: #F6F5ED;
      margin: 0
    }

    .admin-panel {
      max-width: 1200px;
      margin: 40px auto;
      padding: 20px
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center
    }

    .btn {
      padding: 8px 14px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600
    }

    .btn-add {
      background: #28a745;
      color: white
    }

    .btn-logout {
      background: #dc3545;
      color: white
    }

    .stat-box {
      background: white;
      padding: 15px;
      border-radius: 10px;
      margin: 10px;
      display: inline-block
    }

    .card {
      background: white;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 15px
    }

    .btn-delete {
      background: #FF6600;
      color: white;
      border: none;
      padding: 6px 10px;
      border-radius: 5px
    }
  </style>
</head>

<body>

  <section class="admin-panel">
    <div class="top-bar">
      <h1>Admin Dashboard</h1>
      <div>
        <a href="add_resident.php" class="btn btn-add">➕ Add Resident</a>
        <a href="admin_logout.php" class="btn btn-logout">Logout</a>
      </div>
    </div>

    <div>
      <div class="stat-box">Users: <?= $user_count ?></div>
      <div class="stat-box">Professionals: <?= $pro_count ?></div>
      <div class="stat-box">Orders: <?= $order_count ?></div>
    </div>

    <h2>Users</h2>
    <?php
    $users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
    while ($u = $users->fetch_assoc()):
    ?>
      <div class="card">
        <?= htmlspecialchars($u['full_name']) ?> | <?= htmlspecialchars($u['email']) ?>
        <form method="POST" style="display:inline">
          <input type="hidden" name="delete_id" value="<?= $u['user_id'] ?>">
          <input type="hidden" name="delete_type" value="user">
          <button class="btn-delete">Delete</button>
        </form>
      </div>
    <?php endwhile; ?>

  </section>

</body>

</html>