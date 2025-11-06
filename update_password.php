<?php
include 'config/database.php';

if (isset($_POST['token'], $_POST['new_password'])) {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE admins SET password = ?, reset_token = NULL WHERE reset_token = ?");
    $stmt->bind_param("ss", $new_password, $token);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Password successfully updated. Please login.'); window.location='login.php';</script>";
    } else {
        echo "Token invalid or expired.";
    }
}
?>