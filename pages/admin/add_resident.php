<?php
require_once 'admin_auth.php';
require_once 'db_config.php';

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if (!$name || !$email || !$phone) {
        $error = "All fields are required.";
    } else {
        $plainPassword = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ23456789"), 0, 8);
        $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);

        $stmt = $conn->prepare(
            "INSERT INTO users (full_name, email, phone, password) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $name, $email, $phone, $hashedPassword);

        if ($stmt->execute()) {
            $userId = $stmt->insert_id;

            // map admin -> user
            $adminId = $_SESSION['admin_id'];
            $map = $conn->prepare("INSERT INTO admin_users (admin_id, user_id) VALUES (?, ?)");
            $map->bind_param("ii", $adminId, $userId);
            $map->execute();

            header("Location: send_credentials.php?email=$email&pass=$plainPassword&name=" . urlencode($name));
            exit();
        } else {
            $error = "Failed to create resident.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Resident - Admin</title>
<link rel="stylesheet" href="../../assets/css/style.css">
<style>
.admin-container {
  max-width: 600px;
  margin: 60px auto;
  background: #fff;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}
.admin-container h2 {
  color: #FF6600;
  margin-bottom: 20px;
}
.form-group {
  margin-bottom: 15px;
}
.form-group label {
  display: block;
  font-weight: 600;
  margin-bottom: 5px;
}
.form-group input {
  width: 100%;
  padding: 10px;
  border-radius: 6px;
  border: 1px solid #ccc;
}
.btn-primary {
  background: #FF6600;
  border: none;
  color: #fff;
  padding: 12px;
  width: 100%;
  border-radius: 6px;
  font-weight: bold;
  cursor: pointer;
}
.btn-primary:hover {
  background: #e05a00;
}
.alert {
  padding: 10px;
  margin-bottom: 15px;
  border-radius: 6px;
}
.alert-error {
  background: #ffe6e6;
  color: #b30000;
}
.note {
  margin-top: 15px;
  font-size: 0.9rem;
  color: #555;
}
.back-link {
  display: inline-block;
  margin-top: 20px;
  text-decoration: none;
  color: #333;
}
</style>
</head>
<body>

<div class="admin-container">
  <h2>➕ Add New Resident</h2>

  <?php if ($error): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="form-group">
      <label>Full Name</label>
      <input type="text" name="full_name" required>
    </div>

    <div class="form-group">
      <label>Email Address</label>
      <input type="email" name="email" required>
    </div>

    <div class="form-group">
      <label>Phone Number</label>
      <input type="text" name="phone" required>
    </div>

    <button type="submit" class="btn-primary">
      Create Resident & Send Credentials
    </button>
  </form>

  <div class="note">
    📧 Login credentials will be emailed automatically to the resident.
  </div>

  <a href="admin_dashboard.php" class="back-link">← Back to Dashboard</a>
</div>

</body>
</html>
