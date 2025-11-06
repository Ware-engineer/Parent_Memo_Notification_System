<?php
session_start();
include 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT email, password FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

   if ($admin = $result->fetch_assoc()) {
    if (password_verify($password, $admin['password'])) {
        // Already hashed password
        $_SESSION['admin'] = $admin['email'];
        header("Location: dashboard.php");
        exit();
    } elseif ($password === $admin['password']) {
        // Plain text fallback – rehash it
        $newHashed = password_hash($password, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE admins SET password = ? WHERE email = ?");
        $update->bind_param("ss", $newHashed, $email);
        $update->execute();

        $_SESSION['admin'] = $admin['email'];
        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: login.php?error=Invalid+password");
        exit();
    }
}
}