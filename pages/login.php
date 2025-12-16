<?php
session_start();
require_once 'db_config.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT user_id, full_name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id, $full_name, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                // ✅ Store user details in session
                $_SESSION['user_id'] = $user_id;
                $_SESSION['full_name'] = $full_name;
                $_SESSION['user_email'] = $email;

                // ✅ Safe redirect logic
                $redirect = "../index.php";
                if (!empty($_GET['redirect'])) {
                    $r = $_GET['redirect'];
                    if (strpos($r, 'http://') === false && strpos($r, 'https://') === false) {
                        $redirect = $r;
                    }
                }
                header("Location: " . $redirect);
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }
        $stmt->close();
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Login / Register - HomEase</title>
<link rel="stylesheet" href="../assets/css/style.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
  .redirect-notice {
    background: #fff5e5;
    border: 1px solid #ffb84d;
    color: #b35b00;
    padding: 12px 20px;
    border-radius: 8px;
    margin: 20px auto;
    max-width: 600px;
    font-size: 1rem;
    font-weight: 500;
    text-align: center;
  }
</style>
</head>
<body>

<!-- Navigation Header -->
<header class="navbar">
  <div class="navbar-content">
    <div class="logo">
      <span><img src="../assets/images/logo.png" alt="HomEase Logo" /></span>
    </div>
    <nav class="nav-menu">
      <a href="../index.php" class="nav-link">Home</a>
      <a href="services.php" class="nav-link">Services</a>
      <a href="contact.php" class="nav-link">Contact</a>
      <a href="blog.php" class="nav-link">Blog</a>
    </nav>
    <div class="navbar-right">
      <a href="login.php" class="cta-btn">Login</a>
    </div>
  </div>
</header>

<!-- 🔶 Redirect Notice -->
<?php if (!empty($_GET['redirect'])): 
  // extract service name if available in redirect query
  parse_str(parse_url($_GET['redirect'], PHP_URL_QUERY), $qs);
  $serviceName = isset($qs['service']) ? ucfirst(htmlspecialchars($qs['service'])) : 'the requested service';
?>
  <div class="redirect-notice">
    ⚠️ Please log in to continue booking your <b><?= $serviceName ?></b>.
  </div>
<?php endif; ?>

<!-- Auth Section -->
<section class="auth-section">
  <div class="auth-container">

    <!-- Login Form -->
    <div class="auth-form-wrapper" id="loginForm">
      <h2>Welcome Back</h2>
      <p>Sign in to your HomEase account</p>

      <!-- preserve redirect -->
      <form class="auth-form" method="POST" action="login.php<?php echo isset($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : ''; ?>">
        <div class="form-group">
          <label for="loginEmail">Email Address</label>
          <input type="email" id="loginEmail" name="email" placeholder="your@email.com" required />
        </div>
        <div class="form-group">
          <label for="loginPassword">Password</label>
          <input type="password" id="loginPassword" name="password" placeholder="Enter your password" required />
        </div>
        <div class="form-remember" style="margin-bottom: 10px;">
          <input type="checkbox" id="rememberMe" />
          <label for="rememberMe">Remember me</label>
        </div>

        <?php if (!empty($error)): ?>
          <p style="color: red;"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if (isset($_GET['registered'])): ?>
          <p style="color: green; margin-top: 10px;">Registration successful! You can now log in.</p>
        <?php endif; ?>

        <button type="submit" name="login" class="btn btn-primary btn-full">Sign In</button>
      </form>

      <p class="auth-toggle">
        Don't have an account? <a href="#" onclick="toggleForms()">Register here</a>
      </p>
    </div>

    <!-- Register Form -->
    <div class="auth-form-wrapper hidden" id="registerForm">
      <h2>Create Account</h2>
      <p>Join HomEase to book services easily</p>
      <form class="auth-form" action="register.php" method="POST">
        <div class="form-group">
          <label for="registerName">Full Name</label>
          <input type="text" id="registerName" name="name" placeholder="John Doe" required>
        </div>
        <div class="form-group">
          <label for="registerEmail">Email Address</label>
          <input type="email" id="registerEmail" name="email" placeholder="your@email.com" required>
        </div>
        <div class="form-group">
          <label for="registerPhone">Phone Number</label>
          <input type="tel" id="registerPhone" name="phone" placeholder="(555) 123-4567" required>
        </div>
        <div class="form-group">
          <label for="registerPassword">Password</label>
          <input type="password" id="registerPassword" name="password" placeholder="Create a password" required>
        </div>
        <div class="form-group">
          <label for="registerConfirm">Confirm Password</label>
          <input type="password" id="registerConfirm" name="confirm_password" placeholder="Confirm password" required>
        </div>
        <div class="form-checkbox" style="margin-bottom: 10px;">
          <input type="checkbox" id="agreeTerms" required>
          <label for="agreeTerms">I agree to the Terms of Service</label>
        </div>
        <button type="submit" class="btn btn-primary btn-full">Create Account</button>
      </form>
      <p class="auth-toggle">Already have an account? <a href="#" onclick="toggleForms()">Sign in here</a></p>
    </div>

    <!-- Auth Image -->
    <div class="auth-image">
      <div class="auth-image-content">
        <h3>Why Choose HomEase?</h3>
        <ul class="benefits-list">
          <li>✓ Verified professionals</li>
          <li>✓ Transparent pricing</li>
          <li>✓ 24/7 customer support</li>
          <li>✓ Satisfaction guaranteed</li>
          <li>✓ Easy booking process</li>
          <li>✓ Secure payments</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
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


<div class="cursor-dot"></div>
<div class="cursor-outline"></div>

<script src="../script.js"></script>
<script>
function toggleForms() {
  document.getElementById('loginForm').classList.toggle('hidden');
  document.getElementById('registerForm').classList.toggle('hidden');
}
</script>

</body>
</html>
