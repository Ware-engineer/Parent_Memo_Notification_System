<?php
include 'config/database.php';

if (!isset($_GET['token'])) {
    die("Invalid or missing reset token.");
}

$token = $_GET['token'];
$stmt = $conn->prepare("SELECT * FROM admins WHERE reset_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

if (!$admin) {
    die("Invalid or expired reset token.");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card p-4 shadow" style="width: 400px;">
        <h4 class="text-center mb-3">Reset Password</h4>
        <form action="update_password.php" method="POST">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <div class="mb-3">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" required minlength="6">
            </div>
            <button type="submit" class="btn btn-success w-100">Update Password</button>
        </form>
    </div>
</body>

</html>