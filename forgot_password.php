<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card p-4 shadow" style="width: 400px;">
        <h4 class="text-center mb-3">Forgot Password</h4>
        <form action="send_reset_link.php" method="POST">
            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" required placeholder="Enter admin email">
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
        </form>
        <div class="mt-3 text-center">
            <a href="login.php">⬅ Back to Login</a>
        </div>
    </div>
</body>

</html>