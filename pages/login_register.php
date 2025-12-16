<?php
session_start();
require_once 'db_config.php';

// ------------------ Registration ------------------
if (isset($_POST['action']) && $_POST['action'] === 'register') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = 'Passwords do not match!';
        $_SESSION['active_form'] = 'register';
        header("Location: ../index.php");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $checkEmail = $stmt->get_result();

    if ($checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = 'Email is already registered!';
        $_SESSION['active_form'] = 'register';
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $hashed_password);
        $stmt->execute();
        $_SESSION['register_success'] = 'Registration successful! You can now log in.';
        $_SESSION['active_form'] = 'login'; // show login form after successful registration
    }

    header("Location: ../index.php");
    exit();
}

// ------------------ Login ------------------
if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Select user by email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone'] = $user['phone'];

            header("Location: ../dashboard.php");
            exit();
        } else {
            $_SESSION['login_error'] = 'Incorrect password!';
            $_SESSION['active_form'] = 'login';
        }
    } else {
        $_SESSION['login_error'] = 'Email not registered!';
        $_SESSION['active_form'] = 'login';
    }

    header("Location: ../index.php");
    exit();
}
?>
