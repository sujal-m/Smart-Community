<?php
require_once 'admin_auth.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';

$name = $_GET['name'];
$email = $_GET['email'];
$password = $_GET['pass'];

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'smart.community27@gmail.com';
    $mail->Password = 'yemywajjjcwtxbky';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('YOUR_GMAIL@gmail.com', 'HomEase');
    $mail->addAddress($email, $name);

    $mail->Subject = 'Your HomEase Login Credentials';
    $mail->Body = "
Hello $name,

Your Smart Community account has been created by the admin.

Login Email: $email
Password: $password

Please login and change your password after first login.

Regards,
HomEase Team
";

    $mail->send();
} catch (Exception $e) {
    die("Mail error: " . $mail->ErrorInfo);
}

header("Location: admin_dashboard.php");
exit();
