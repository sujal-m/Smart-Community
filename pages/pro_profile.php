<?php
session_start();
require 'db_config.php';

// Redirect if not logged in
if (!isset($_SESSION['pro_id'])) {
    header("Location: pro_login.php");
    exit();
}

$pro_id = $_SESSION['pro_id'];

// Fetch professional details
$query = "SELECT * FROM professional WHERE pro_id = '$pro_id'";
$result = mysqli_query($conn, $query);
$pro = mysqli_fetch_assoc($result);

// Update profile
if (isset($_POST['update_profile'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $skill_type = mysqli_real_escape_string($conn, $_POST['skill_type']);
    $other_skill = mysqli_real_escape_string($conn, $_POST['other_skill']);

    $update_query = "UPDATE professional 
                     SET full_name='$full_name', phone='$phone', skill_type='$skill_type', other_skill='$other_skill' 
                     WHERE pro_id='$pro_id'";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='pro_profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile!');</script>";
    }
}

// Change password
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch current hash
    $res = mysqli_query($conn, "SELECT password FROM professional WHERE pro_id='$pro_id'");
    $row = mysqli_fetch_assoc($res);

    if (password_verify($current_password, $row['password'])) {
        if ($new_password === $confirm_password) {
            $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE professional SET password='$new_hashed' WHERE pro_id='$pro_id'");
            echo "<script>alert('Password changed successfully!'); window.location.href='pro_profile.php';</script>";
        } else {
            echo "<script>alert('New passwords do not match!');</script>";
        }
    } else {
        echo "<script>alert('Incorrect current password!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Profile | HomEase Professional</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header class="navbar">
    <div class="navbar-content">
        <div class="logo">
            <span><img src="../assets/images/logo.png" alt="HomEase Logo" /></span>
        </div>
        <nav class="nav-menu">
            <a href="../index.php">Home</a>
            <a href="services.php">Services</a>
            <a href="contact.php">Contact</a>
        </nav>
        <div class="navbar-right">
            <span>Welcome, <?php echo htmlspecialchars($pro['full_name']); ?></span>
            <a href="pro_dashboard.php" class="cta-btn">Dashboard</a>
            <a href="pro_login.php?logout=true" class="cta-btn">Logout</a>
        </div>
    </div>
</header>

<section class="auth-section" style="padding-top: 100px;">
    <div class="auth-container">
        <h2>Manage Profile</h2>
        <form method="POST" class="auth-form">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($pro['full_name']); ?>" required>
            </div>
            <div class="form-group">
                <label>Email (read-only)</label>
                <input type="email" value="<?php echo htmlspecialchars($pro['email']); ?>" readonly>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($pro['phone']); ?>" required>
            </div>
            <div class="form-group">
                <label>Primary Skill</label>
                <input type="text" name="skill_type" value="<?php echo htmlspecialchars($pro['skill_type']); ?>" required>
            </div>
            <div class="form-group">
                <label>Other Skill</label>
                <input type="text" name="other_skill" value="<?php echo htmlspecialchars($pro['other_skill']); ?>">
            </div>
            <button type="submit" name="update_profile" class="cta-btn">Update Profile</button>
        </form>

        <hr style="margin: 30px 0;">

        <h3>Change Password</h3>
        <form method="POST" class="auth-form">
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password" required>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" required>
            </div>
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit" name="change_password" class="cta-btn">Change Password</button>
        </form>
    </div>
</section>

</body>
</html>
