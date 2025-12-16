<?php
session_start();
require_once 'db_config.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT user_id, full_name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $full_name, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['full_name'] = $full_name;
            $_SESSION['user_email'] = $email;

            header("Location: ../index.php");
            exit();
        }
    }

    $error = "Invalid email or password.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Login - HomEase</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
.login-container {
  max-width: 420px;
  margin: 80px auto;
  background: #fff;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}
.login-container h2 {
  text-align: center;
  color: #FF6600;
}
.login-container p {
  text-align: center;
  color: #666;
  margin-bottom: 20px;
}
.form-group {
  margin-bottom: 15px;
}
.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: 600;
}
.form-group input {
  width: 100%;
  padding: 10px;
  border-radius: 6px;
  border: 1px solid #ccc;
}
.btn-primary {
  width: 100%;
  padding: 12px;
  background: #FF6600;
  border: none;
  color: #fff;
  font-weight: bold;
  border-radius: 6px;
  cursor: pointer;
}
.btn-primary:hover {
  background: #e05a00;
}
.error {
  background: #ffe6e6;
  color: #b30000;
  padding: 10px;
  border-radius: 6px;
  margin-bottom: 15px;
  text-align: center;
}
.note {
  text-align: center;
  margin-top: 15px;
  font-size: 0.9rem;
  color: #555;
}
</style>
</head>
<body>

<div class="login-container">
  <h2>Welcome Back</h2>
  <p>Login to your HomEase account</p>

  <?php if ($error): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="form-group">
      <label>Email Address</label>
      <input type="email" name="email" required>
    </div>

    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" required>
    </div>

    <button type="submit" class="btn-primary">Login</button>
  </form>

  <div class="note">
    🔒 Credentials are provided by the administrator
  </div>
</div>

</body>
</html>
