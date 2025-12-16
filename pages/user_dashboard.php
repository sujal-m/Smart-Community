<?php
require_once __DIR__ . '/db_config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first!'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$user_query = $conn->prepare("SELECT full_name, email, phone FROM users WHERE user_id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateProfile'])) {
    $new_name = $_POST['full_name'];
    $new_phone = $_POST['phone'];

    $update_stmt = $conn->prepare("UPDATE users SET full_name = ?, phone = ? WHERE user_id = ?");
    $update_stmt->bind_param("ssi", $new_name, $new_phone, $user_id);
    $update_stmt->execute();

    echo "<script>alert('Profile updated successfully!'); window.location.href='user_dashboard.php';</script>";
    exit();
}

// ✅ Fetch user's orders + professional details
$order_query = $conn->prepare("
    SELECT 
        o.service, o.booking_datetime, o.address, o.phone, o.cost, o.status,
        p.full_name AS pro_name, p.phone AS pro_phone, p.email AS pro_email
    FROM orders o
    LEFT JOIN professional p ON o.pro_id = p.pro_id
    WHERE o.user_id = ?
    ORDER BY o.created_at DESC
");
$order_query->bind_param("i", $user_id);
$order_query->execute();
$order_result = $order_query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard | HomEase</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        :root {
            --orange: #ff6600;
            --light-gray: #f8f9fb;
        }

        body {
            background-color: var(--light-gray);
            font-family: 'Poppins', sans-serif;
        }

        /* Make normal cursor visible */
        body, button, a, input, textarea, select {
            cursor: auto !important;
        }
        .cursor-dot,
        .cursor-outline {
            display: none !important;
        }

        .dashboard-section {
            padding: 40px 60px;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: auto;
        }

        .dashboard-container h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 28px;
            color: #333;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
            align-items: flex-start;
        }

        .dashboard-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 25px 30px;
        }

        .dashboard-card h3 {
            margin-bottom: 15px;
            color: var(--orange);
            font-size: 22px;
        }

        .auth-form .form-group {
            margin-bottom: 15px;
        }

        .auth-form input {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .btn {
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-primary {
            background: var(--orange);
            color: #fff;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 15px;
        }

        .orders-table th, .orders-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        .orders-table th {
            background: #fff3eb;
            color: #444;
        }

        .orders-table tr:hover {
            background-color: #fffaf6;
        }

        .pro-details {
            font-size: 0.9rem;
            background: #f9f9f9;
            border-radius: 8px;
            padding: 6px 10px;
            line-height: 1.5;
        }

        .pro-details span {
            display: block;
        }

        /* Responsive fix */
        @media(max-width: 992px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<header class="navbar">
    <div class="navbar-content">
        <div class="logo">
            <img src="../assets/images/logo.png" alt="HomEase Logo">
        </div>
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
        <h2>Welcome, <?php echo htmlspecialchars($user['full_name']); ?> 👋</h2>

        <div class="dashboard-grid">
            <!-- Profile Info -->
            <div class="dashboard-card">
                <h3>Your Profile</h3>
                <form method="POST" class="auth-form">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email (cannot be changed)</label>
                        <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required pattern="[0-9]{10}">
                    </div>
                    <button type="submit" name="updateProfile" class="btn btn-primary">Update Profile</button>
                </form>
            </div>

            <!-- Orders Section -->
            <div class="dashboard-card">
                <h3>Your Orders</h3>
                <?php if ($order_result->num_rows > 0): ?>
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Date & Time</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Cost</th>
                                <th>Status</th>
                                <th>Professional</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = $order_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order['service']); ?></td>
                                    <td><?php echo date("d M Y, h:i A", strtotime($order['booking_datetime'])); ?></td>
                                    <td><?php echo htmlspecialchars($order['address']); ?></td>
                                    <td><?php echo htmlspecialchars($order['phone']); ?></td>
                                    <td>₹<?php echo htmlspecialchars($order['cost']); ?></td>
                                    <td>
                                        <?php
                                            $status = htmlspecialchars($order['status']);
                                            $statusClass = match($status) {
                                                'pending' => 'color:#ffc107;',
                                                'accepted' => 'color:#ff6600;',
                                                'completed' => 'color:#28a745;',
                                                'rejected' => 'color:#dc3545;',
                                                default => 'color:#333;'
                                            };
                                        ?>
                                        <span style="font-weight:600; <?php echo $statusClass; ?>">
                                            <?php echo ucfirst($status); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if (!empty($order['pro_name'])): ?>
                                            <div class="pro-details">
                                                <span><strong><?php echo htmlspecialchars($order['pro_name']); ?></strong></span>
                                                <span>📞 <?php echo htmlspecialchars($order['pro_phone']); ?></span>
                                                <span>✉️ <?php echo htmlspecialchars($order['pro_email']); ?></span>
                                            </div>
                                        <?php else: ?>
                                            <span style="color:#888;">Not assigned yet</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>You haven’t booked any services yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<footer class="footer">
  <div class="container">
    <div class="footer-content">
      <div class="footer-section">
        <img src="../assets/images/logo_white.png" alt="HomEase logo white" loading="lazy" />
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
          <a href="https://www.facebook.com/" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="https://www.twitter.com/" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
          <a href="https://www.instagram.com/" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
          <a href="https://www.linkedin.com/" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; 2025 HomEase. All rights reserved.</p>
    </div>
  </div>
</footer>

</body>
</html>
