<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "homease_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id']) && isset($_POST['delete_type'])) {
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

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$user_count = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$pro_count = $conn->query("SELECT COUNT(*) AS total FROM professional")->fetch_assoc()['total'];
$order_count = $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Admin Dashboard - HomEase</title>
<link rel="stylesheet" href="../assets/css/style.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<style>
  body {
    font-family: 'Poppins', sans-serif;
    background-color: #F6F5ED;
    margin: 0;
  }

  body, button, a, input, textarea, select {
    cursor: auto !important;
  }
  .cursor-dot,
  .cursor-outline {
    display: none !important;
  }

  header.navbar {
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  }

  section.admin-panel {
    max-width: 1200px;
    margin: 40px auto 80px auto;
    padding: 0 20px;
  }

  h1 {
    color: #FF6600;
    text-align: center;
    margin-bottom: 10px;
  }

  .stats-container {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin: 25px 0 45px;
    flex-wrap: wrap;
  }

  .stat-box {
    background: #fff;
    padding: 18px 30px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    font-weight: 600;
    font-size: 1rem;
  }

  .user-list, .pro-list, .bookings {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 40px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  }

  h2 {
    color: #333;
    border-left: 4px solid #FF6600;
    padding-left: 10px;
    margin-bottom: 15px;
  }

  .user-card, .pro-card, .booking-card {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    border-bottom: 1px solid #eee;
    padding: 12px 0;
    font-size: 0.95rem;
    align-items: center; /* ✅ Fix: vertically align inline */
  }

  .user-card span, .pro-card span, .booking-card span {
    flex: 1 1 180px;
    margin-right: 10px;
    line-height: 1.6;
    display: inline-block;
    vertical-align: middle;
  }

  .btn-delete {
    background-color: #FF6600;
    border: none;
    color: white;
    padding: 8px 14px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s;
  }

  .btn-delete:hover {
    background-color: #e05a00;
  }

  footer {
    background-color: #222042;
    color: #ccc;
    text-align: center;
    padding: 16px 0;
  }

  @media (max-width: 768px) {
    .user-card, .pro-card, .booking-card {
      flex-direction: column;
      align-items: flex-start;
    }
  }
</style>
</head>
<body>

<!-- Header -->
<header class="navbar">
  <div class="navbar-content">
    <div class="logo">
      <img src="../assets/images/logo.png" alt="HomEase logo" />
    </div>
    <nav class="nav-menu">
      <a href="../index.php" class="nav-link">Home</a>
      <a href="admin.php" class="nav-link active">Admin</a>
    </nav>
  </div>
</header>

<!-- Admin Panel -->
<section class="admin-panel">
  <h1>Admin Management Dashboard</h1>

  <div class="stats-container">
    <div class="stat-box">👤 Users: <?php echo $user_count; ?></div>
    <div class="stat-box">🧰 Professionals: <?php echo $pro_count; ?></div>
    <div class="stat-box">📦 Orders: <?php echo $order_count; ?></div>
  </div>

  <!-- Users -->
  <h2>All Users</h2>
  <div class="user-list">
    <?php
    $users = $conn->query("SELECT user_id, full_name, email, phone, created_at FROM users ORDER BY created_at DESC");
    if ($users && $users->num_rows > 0) {
        while ($u = $users->fetch_assoc()) {
            echo '<div class="user-card">';
            echo '<span><b>Name:</b> ' . htmlspecialchars($u['full_name']) . '</span>';
            echo '<span><b>Email:</b> ' . htmlspecialchars($u['email']) . '</span>';
            echo '<span><b>Phone:</b> ' . htmlspecialchars($u['phone']) . '</span>';
            echo '<span><b>Joined:</b> ' . date("d M Y", strtotime($u['created_at'])) . '</span>';
            echo '<form method="POST">
                    <input type="hidden" name="delete_id" value="' . intval($u['user_id']) . '">
                    <input type="hidden" name="delete_type" value="user">
                    <button type="submit" class="btn-delete" onclick="return confirm(\'Delete this user?\')">Delete</button>
                  </form>';
            echo '</div>';
        }
    } else {
        echo '<p>No user records found.</p>';
    }
    ?>
  </div>

  <!-- Professionals -->
  <h2>All Professionals</h2>
  <div class="pro-list">
    <?php
    $pros = $conn->query("SELECT pro_id, full_name, email, phone, skill_type, other_skill, created_at FROM professional ORDER BY created_at DESC");
    if ($pros && $pros->num_rows > 0) {
        while ($p = $pros->fetch_assoc()) {
            echo '<div class="pro-card">';
            echo '<span><b>Name:</b> ' . htmlspecialchars($p['full_name']) . '</span>';
            echo '<span><b>Email:</b> ' . htmlspecialchars($p['email']) . '</span>';
            echo '<span><b>Phone:</b> ' . htmlspecialchars($p['phone']) . '</span>';
            echo '<span><b>Skill Type:</b> ' . htmlspecialchars($p['skill_type']) . '</span>';
            if (!empty($p['other_skill'])) {
                echo '<span><b>Other Skill:</b> ' . htmlspecialchars($p['other_skill']) . '</span>';
            }
            echo '<span><b>Joined:</b> ' . date("d M Y", strtotime($p['created_at'])) . '</span>';
            echo '<form method="POST">
                    <input type="hidden" name="delete_id" value="' . intval($p['pro_id']) . '">
                    <input type="hidden" name="delete_type" value="pro">
                    <button type="submit" class="btn-delete" onclick="return confirm(\'Delete this professional?\')">Delete</button>
                  </form>';
            echo '</div>';
        }
    } else {
        echo '<p>No professional records found.</p>';
    }
    ?>
  </div>

  <!-- Orders -->
  <h2>All Orders</h2>
  <div class="bookings">
    <?php
    $orders = $conn->query("
      SELECT o.order_id, u.full_name AS user_name, p.full_name AS pro_name, o.service, o.booking_datetime, o.cost, o.status
      FROM orders o
      LEFT JOIN users u ON o.user_id = u.user_id
      LEFT JOIN professional p ON o.pro_id = p.pro_id
      ORDER BY o.created_at DESC
    ");
    if ($orders && $orders->num_rows > 0) {
        while ($o = $orders->fetch_assoc()) {
            echo '<div class="booking-card">';
            echo '<span><b>Order ID:</b> #' . $o['order_id'] . '</span>';
            echo '<span><b>User:</b> ' . htmlspecialchars($o['user_name']) . '</span>';
            echo '<span><b>Service:</b> ' . htmlspecialchars($o['service']) . '</span>';
            echo '<span><b>Professional:</b> ' . ($o['pro_name'] ? htmlspecialchars($o['pro_name']) : '<em>Unassigned</em>') . '</span>';
            echo '<span><b>Date & Time:</b> ' . date("d M Y, h:i A", strtotime($o['booking_datetime'])) . '</span>';
            echo '<span><b>Cost:</b> ₹' . htmlspecialchars($o['cost']) . '</span>';
            echo '<span><b>Status:</b> ' . ucfirst($o['status']) . '</span>';
            echo '</div>';
        }
    } else {
        echo '<p>No orders found.</p>';
    }
    ?>
  </div>
</section>

<!-- Footer -->
<footer>
  <p>&copy; 2025 HomEase. All rights reserved.</p>
</footer>

</body>
</html>
