<?php
include 'config/database.php';
include 'send_email.php'; // your working PHPMailer wrapper

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT id FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($admin = $result->fetch_assoc()) {
        $token = bin2hex(random_bytes(32));
        $update = $conn->prepare("UPDATE admins SET reset_token = ? WHERE email = ?");
        $update->bind_param("ss", $token, $email);
        $update->execute();

        $link = "http://localhost/Kiriti_girls_system/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $body = "Hello,<br><br>Click the link below to reset your password:<br><a href='$link'>$link</a><br><br>This link will expire after use.";

        if (sendMail($email, $subject, $body)) {
            echo "<script>alert('Password reset link sent to your email.'); window.location='login.php';</script>";
        } else {
            echo "Failed to send email. Please check email configuration.";
        }
    } else {
        echo "<script>alert('Email not found.'); window.history.back();</script>";
    }
}
?>