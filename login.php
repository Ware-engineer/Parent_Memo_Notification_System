<?php
session_start();
if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login - Kiriti Girls</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-image: url('assets/school-bg.jpg');
            /* Replace with actual background image */
            background-size: cover;
            background-position: center;
        }

        .login-box {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            margin: auto;
        }

        .form-title {
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100">

    <div class="login-box text-center">
        <h3 class="form-title">Kiriti Girls Admin Login</h3>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <form action="process_login.php" method="POST">
            <div class="mb-3 text-start">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>
            <div class="mb-3 text-start">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="d-grid">
                <button class="btn btn-primary" type="submit">Login</button>
            </div>
        </form>

        <div class="mt-3">
            <a href="forgot_password.php" class="text-decoration-none">Forgot Password?</a>
        </div>
    </div>

</body>

</html>