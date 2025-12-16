<?php
require 'db_config.php';
session_start();

// Handle Professional Registration
if (isset($_POST['register'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['registerName']);
    $email = mysqli_real_escape_string($conn, $_POST['registerEmail']);
    $phone = mysqli_real_escape_string($conn, $_POST['registerPhone']);
    $password = password_hash($_POST['registerPassword'], PASSWORD_DEFAULT);
    $skill_type = mysqli_real_escape_string($conn, $_POST['skillType']);
    $other_skill = mysqli_real_escape_string($conn, $_POST['otherSkill']);
    $created_at = date('Y-m-d H:i:s');

    // Check if email exists
    $checkQuery = "SELECT * FROM professional WHERE email='$email'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('Email already registered. Please login instead.');</script>";
    } else {
        $insertQuery = "INSERT INTO professional (full_name, email, phone, password, skill_type, other_skill, created_at)
                        VALUES ('$full_name', '$email', '$phone', '$password', '$skill_type', '$other_skill', '$created_at')";
        if (mysqli_query($conn, $insertQuery)) {
            echo "<script>alert('Registration successful! You can now log in.');</script>";
        } else {
            echo "<script>alert('Error: Unable to register.');</script>";
        }
    }
}

// Handle Professional Login
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['loginEmail']);
    $password = $_POST['loginPassword'];

    $sql = "SELECT * FROM professional WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['pro_id'] = $row['pro_id'];
            $_SESSION['pro_name'] = $row['full_name'];
            header("Location: pro_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid password.');</script>";
        }
    } else {
        echo "<script>alert('No account found with this email.');</script>";
    }
}

// Handle Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: pro_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Professional Login | HomEase</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                <?php if (isset($_SESSION['pro_name'])): ?>
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['pro_name']); ?></span>
                    <a href="?logout=true" class="cta-btn">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="cta-btn">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Professional Login Section -->
    <section class="auth-section">
        <div class="auth-container">
            <!-- LOGIN FORM -->
            <div class="auth-form-wrapper" id="Pro_login" <?php if(isset($_POST['register'])) echo 'class="hidden"'; ?>>
                <h2>Welcome Back</h2>
                <p>Sign in to your HomEase account</p>
                <form class="auth-form" method="POST" action="">
                    <div class="form-group">
                        <label for="loginEmail">Email Address</label>
                        <input type="email" id="loginEmail" name="loginEmail" placeholder="your@email.com" required />
                    </div> 
                    <div class="form-group">
                        <label for="loginPassword">Password</label>
                        <input type="password" id="loginPassword" name="loginPassword" placeholder="Enter your password" required />
                    </div>
                    <div class="form-remember" style="margin-bottom: 10px;">
                        <input type="checkbox" id="rememberMe" />
                        <label for="rememberMe">Remember me</label>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary btn-full">Sign In</button>
                </form>
                <p class="auth-toggle">
                    Don't have an account?
                    <a href="#" onclick="return toggleForm()">Register here</a>
                </p>
            </div>

            <!-- REGISTER FORM -->
            <div class="auth-form-wrapper hidden" id="registerForm">
                <h2>Create Account</h2>
                <p>Join HomEase to book services easily</p>
                <form class="auth-form" method="POST" action="">
                    <div class="form-group">
                        <label for="registerName">Full Name</label>
                        <input type="text" id="registerName" name="registerName" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label for="registerEmail">Email Address</label>
                        <input type="email" id="registerEmail" name="registerEmail" placeholder="your@email.com" required>
                    </div>
                    <div class="form-group">
                        <label for="registerPhone">Phone Number</label>
                        <input type="tel" id="registerPhone" name="registerPhone" placeholder="(555) 123-4567" required>
                    </div>
                    <div class="form-group">
                        <label for="registerPassword">Password</label>
                        <input type="password" id="registerPassword" name="registerPassword" placeholder="Create a password" required>
                    </div>
                    <div class="form-group">
                        <label for="registerConfirm">Confirm Password</label>
                        <input type="password" id="registerConfirm" placeholder="Confirm password" required>
                    </div>
                    <div class="form-group">
                        <label for="skillType">Skill Type</label>
                        <select id="skillType" name="skillType" required>
                            <option value="">Select your primary skill</option>
                            <option value="plumbing">Plumbing</option>
                            <option value="electrical">Electrical</option>
                            <option value="carpentry">Carpentry</option>
                            <option value="painting">Painting</option>
                            <option value="cleaning">Cleaning</option>
                            <option value="landscaping">Landscaping</option>
                            <option value="flooring">Flooring</option>
                            <option value="moving">Moving & Hauling</option>
                            <option value="other">Other (specify)</option>
                        </select>
                        <input type="text" id="otherSkill" name="otherSkill" placeholder="Specify other skill" style="display:none; margin-top:8px;">
                    </div>
                    <div class="form-checkbox" style="margin-bottom: 10px;">
                        <input type="checkbox" id="agreeTerms" required>
                        <label for="agreeTerms">I agree to the Terms of Service</label>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary btn-full">Create Account</button>
                </form>
                <p class="auth-toggle">Already have an account? <a href="#" onclick="return toggleForm()">Sign in here</a></p>
            </div>

            <!-- AUTH IMAGE -->
            <div class="auth-image">
                <div class="auth-image-content">
                    <h3>Why Choose HomEase?</h3>
                    <ul class="benefits-list">
                        <li>✓ Earn at your convenience</li>
                        <li>✓ Set your own schedule</li>
                        <li>✓ Access to quality jobs</li>
                        <li>✓ Secure payment system</li>
                        <li>✓ Professional growth opportunities</li>
                        <li>✓ Join a trusted platform</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <img src="../assets/images/logo_white.png" alt="">
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
        function toggleForm() {
            const loginForm = document.getElementById('Pro_login');
            const registerForm = document.getElementById('registerForm');
            loginForm.classList.toggle('hidden');
            registerForm.classList.toggle('hidden');
            return false;
        }

        // Show "Other Skill" field dynamically
        document.getElementById('skillType').addEventListener('change', function() {
            const otherSkill = document.getElementById('otherSkill');
            if (this.value === 'other') {
                otherSkill.style.display = 'block';
                otherSkill.required = true;
            } else {
                otherSkill.style.display = 'none';
                otherSkill.required = false;
            }
        });
    </script>
</body>
</html>
