<?php
require_once __DIR__ . '/db_config.php';
session_start();

if (!isset($_SESSION['pro_id'])) {
    echo "<script>alert('Please login as a professional first!'); window.location.href='pro_login.php';</script>";
    exit();
}

$pro_id = $_SESSION['pro_id'];

// ✅ Fetch pro details
$pro_query = $conn->prepare("SELECT full_name, email, phone FROM professional WHERE pro_id = ?");
$pro_query->bind_param("i", $pro_id);
$pro_query->execute();
$pro_result = $pro_query->get_result();
$pro = $pro_result->fetch_assoc();

// ✅ Handle profile update
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['updateProfile'])) {
    $new_name = $_POST['full_name'];
    $new_phone = $_POST['phone'];
    $update_stmt = $conn->prepare("UPDATE professionals SET full_name=?, phone=? WHERE pro_id=?");
    $update_stmt->bind_param("ssi", $new_name, $new_phone, $pro_id);
    $update_stmt->execute();
    echo "<script>alert('Profile updated successfully!'); window.location.href='pro_dashboard.php';</script>";
    exit();
}

// ✅ Handle Accept / Reject / Complete actions
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['orderAction'])) {
    $order_id = intval($_POST['order_id']);
    $action = $_POST['orderAction'];

    if ($action === 'accept') {
        $stmt = $conn->prepare("UPDATE orders SET pro_id=?, status='accepted', updated_at=NOW() WHERE order_id=? AND pro_id IS NULL");
        $stmt->bind_param("ii", $pro_id, $order_id);
        $stmt->execute();
    } elseif ($action === 'reject') {
        $stmt = $conn->prepare("UPDATE orders SET status='rejected', updated_at=NOW() WHERE order_id=?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
    } elseif ($action === 'complete') {
        $stmt = $conn->prepare("UPDATE orders SET status='completed', updated_at=NOW() WHERE order_id=? AND pro_id=?");
        $stmt->bind_param("ii", $order_id, $pro_id);
        $stmt->execute();
    }

    header("Location: pro_dashboard.php");
    exit();
}

// ✅ Fetch all pending orders (not assigned)
$new_orders = $conn->query("SELECT * FROM orders WHERE pro_id IS NULL AND status='pending' ORDER BY created_at DESC");

// ✅ Fetch this pro's own orders
$my_orders = $conn->prepare("SELECT * FROM orders WHERE pro_id=? ORDER BY created_at DESC");
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
body { background: #F6F6F6; cursor: default !important; }
.dashboard-section { padding: 60px 20px; }
.dashboard-container { max-width: 1200px; margin: auto; }
.dashboard-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 30px; }

.dashboard-card {
  background: #fff;
  padding: 25px;
  border-radius: 15px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.08);
  transition: 0.3s;
}
.dashboard-card:hover { transform: translateY(-4px); }

h2, h3 { color: #333; }

.action-btn {
  border: none;
  border-radius: 6px;
  padding: 8px 14px;
  font-weight: 600;
  cursor: pointer;
  transition: 0.2s;
}
.accept-btn { background: #28a745; color: #fff; }
.reject-btn { background: #dc3545; color: #fff; }
.complete-btn { background: #007bff; color: #fff; }
.action-btn:hover { opacity: 0.9; transform: scale(1.05); }

.orders-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
.orders-table th, .orders-table td {
  border-bottom: 1px solid #ddd;
  padding: 10px;
  text-align: left;
}
.orders-table th { background: #ff6600; color: #fff; }

.cursor-dot, .cursor-outline {
  position: fixed;
  top: 0; left: 0;
  pointer-events: none;
  border-radius: 50%;
  transform: translate(-50%, -50%);
  z-index: 99999;
  transition: transform 0.15s ease-out, opacity 0.2s ease;
  will-change: transform;
}
.cursor-dot { width: 8px; height: 8px; background: #ff6600; opacity: 0.85; }
.cursor-outline { width: 28px; height: 28px; border: 2px solid #ff6600; opacity: 0.25; }
.cursor-hover .cursor-outline { transform: scale(1.4); opacity: 0.5; }
@media (hover:none),(pointer:coarse){.cursor-dot,.cursor-outline{display:none!important;}body{cursor:auto!important;}}
</style>
</head>
<body>

<header class="navbar">
  <div class="navbar-content">
    <div class="logo"><img src="../assets/images/logo.png" alt="HomEase Logo"></div>
    <nav class="nav-menu">
      <a href="../index.php" class="nav-link">Home</a>
      <a href="services.php" class="nav-link">Services</a>
    </nav>
    <div class="navbar-right">
      <a href="logout.php" class="cta-btn">Logout</a>
    </div>
  </div>
</header>

<section class="dashboard-section">
  <div class="dashboard-container">
    <h2>Welcome, <?php echo htmlspecialchars($pro['full_name']); ?> 👷‍♂️</h2>
    <div class="dashboard-grid">

      <!-- Profile Section -->
      <div class="dashboard-card">
        <h3>Your Profile</h3>
        <form method="POST">
          <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" value="<?php echo htmlspecialchars($pro['full_name']); ?>" required>
          </div>
          <div class="form-group">
            <label>Email (cannot be changed)</label>
            <input type="email" value="<?php echo htmlspecialchars($pro['email']); ?>" disabled>
          </div>
          <div class="form-group">
            <label>Phone</label>
            <input type="tel" name="phone" value="<?php echo htmlspecialchars($pro['phone']); ?>" required pattern="[0-9]{10}">
          </div>
          <button type="submit" name="updateProfile" class="cta-btn">Update Profile</button>
        </form>
      </div>

      <!-- Orders Section -->
      <div class="dashboard-card">
        <h3>🆕 New Orders</h3>
        <?php if ($new_orders->num_rows > 0): ?>
          <table class="orders-table">
            <thead>
              <tr>
                <th>Service</th><th>Address</th><th>Date</th><th>Phone</th><th>Cost</th><th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($order = $new_orders->fetch_assoc()): ?>
                <tr>
                  <td><?php echo htmlspecialchars($order['service']); ?></td>
                  <td><?php echo htmlspecialchars($order['address']); ?></td>
                  <td><?php echo date("d M Y, h:i A", strtotime($order['booking_datetime'])); ?></td>
                  <td><?php echo htmlspecialchars($order['phone']); ?></td>
                  <td>₹<?php echo htmlspecialchars($order['cost']); ?></td>
                  <td>
                    <form method="POST" style="display:inline;">
                      <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                      <button type="submit" name="orderAction" value="accept" class="action-btn accept-btn">Accept</button>
                    </form>
                    <form method="POST" style="display:inline;">
                      <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                      <button type="submit" name="orderAction" value="reject" class="action-btn reject-btn">Reject</button>
                    </form>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p>No new pending orders right now.</p>
        <?php endif; ?>

        <h3 style="margin-top:30px;">🧾 Your Jobs</h3>
        <?php if ($my_orders_result->num_rows > 0): ?>
          <table class="orders-table">
            <thead>
              <tr>
                <th>Service</th><th>Date</th><th>Address</th><th>Phone</th><th>Cost</th><th>Status</th><th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($job = $my_orders_result->fetch_assoc()): ?>
                <tr>
                  <td><?php echo htmlspecialchars($job['service']); ?></td>
                  <td><?php echo date("d M Y, h:i A", strtotime($job['booking_datetime'])); ?></td>
                  <td><?php echo htmlspecialchars($job['address']); ?></td>
                  <td><?php echo htmlspecialchars($job['phone']); ?></td>
                  <td>₹<?php echo htmlspecialchars($job['cost']); ?></td>
                  <td><?php echo ucfirst($job['status']); ?></td>
                  <td>
                    <?php if ($job['status'] === 'accepted'): ?>
                      <form method="POST" style="display:inline;">
                        <input type="hidden" name="order_id" value="<?php echo $job['order_id']; ?>">
                        <button type="submit" name="orderAction" value="complete" class="action-btn complete-btn">Mark Completed</button>
                      </form>
                    <?php else: ?>—
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p>You haven’t accepted any jobs yet.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- ✅ Full Footer -->
<footer class="footer">
  <div class="container">
    <div class="footer-content">
      <div class="footer-section">
        <img src="../assets/images/logo_white.png" alt="HomEase logo white" />
        <p>Your trusted partner for all handyman services.</p>
      </div>
      <div class="footer-section">
        <h4>Office</h4>
        <ul>
          <li>Bhavan's Campus, Old D N Nagar, Munshi Nagar, Andheri (W), 400-058</li>
          <li><a href="mailto:info@homeease.com">info@homeease.com</a></li>
          <li><a href="tel:+917208248380">+91 7208248380</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="services.php">Services</a></li>
          <li><a href="../index.php?#about">About Us</a></li>
          <li><a href="blog.php">Pricing</a></li>
          <li><a href="blog.php">FAQs</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>For Professionals</h4>
        <ul>
          <li><a href="pro_login.php">Login as Professional</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
        <div class="social-icons">
          <a href="https://www.facebook.com/"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="https://www.twitter.com/"><i class="fa-brands fa-twitter"></i></a>
          <a href="https://www.instagram.com/"><i class="fa-brands fa-instagram"></i></a>
          <a href="https://www.linkedin.com/"><i class="fa-brands fa-linkedin-in"></i></a>
        </div>
      </div>
    </div>
    <div class="footer-bottom"><p>&copy; 2025 HomEase. All rights reserved.</p></div>
  </div>
</footer>

<div class="cursor-dot"></div>
<div class="cursor-outline"></div>
<script>
(() => {
  const dot=document.querySelector('.cursor-dot'),outline=document.querySelector('.cursor-outline');
  if(!dot||!outline)return;
  let mouseX=window.innerWidth/2,mouseY=window.innerHeight/2,posX=mouseX,posY=mouseY;
  const speed=0.18;
  document.addEventListener('mousemove',e=>{mouseX=e.clientX;mouseY=e.clientY;});
  function loop(){posX+=(mouseX-posX)*speed;posY+=(mouseY-posY)*speed;
  dot.style.transform=`translate(${posX}px,${posY}px)`;outline.style.transform=`translate(${posX}px,${posY}px)`;requestAnimationFrame(loop);}loop();
  const hoverTargets=['button','a','input','textarea','.cta-btn'];
  document.addEventListener('mouseover',e=>{if(hoverTargets.some(sel=>e.target.closest(sel)))document.body.classList.add('cursor-hover');});
  document.addEventListener('mouseout',e=>{if(hoverTargets.some(sel=>e.target.closest(sel)))document.body.classList.remove('cursor-hover');});
  if('ontouchstart'in window||navigator.maxTouchPoints>0){dot.style.display='none';outline.style.display='none';document.body.style.cursor='auto';}
})();
</script>
</body>
</html>
