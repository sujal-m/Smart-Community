<?php
require_once 'admin_auth.php';
require_once 'db_config.php';

$error = $success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['full_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];

  $plain = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ23456789"),0,8);
  $hash = password_hash($plain, PASSWORD_BCRYPT);

  $stmt = $conn->prepare("INSERT INTO users (full_name,email,phone,password) VALUES (?,?,?,?)");
  $stmt->bind_param("ssss",$name,$email,$phone,$hash);

  if($stmt->execute()){
    $uid = $stmt->insert_id;
    $map = $conn->prepare("INSERT INTO admin_users (admin_id,user_id) VALUES (?,?)");
    $map->bind_param("ii",$_SESSION['admin_id'],$uid);
    $map->execute();
    header("Location: send_credentials.php?email=$email&pass=$plain&name=".urlencode($name));
    exit();
  }
  $error="Failed to create user";
}
?>
<!DOCTYPE html>
<html>
<head><title>Add Resident</title></head>
<body>
<h2>Add Resident</h2>
<form method="POST">
<input name="full_name" placeholder="Full Name" required>
<input name="email" type="email" placeholder="Email" required>
<input name="phone" placeholder="Phone" required>
<button>Create</button>
</form>
<p style="color:red"><?= $error ?></p>
</body>
</html>
