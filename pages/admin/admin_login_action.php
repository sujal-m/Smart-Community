<?php
require_once 'db_config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT admin_id, password FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['admin_id'];

            header("Location: admin.php");
            exit();
        }
    }

    header("Location: admin_login.php?error=1");
    exit();
}
