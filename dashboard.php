<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            background: url('assets/school_bag.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', sans-serif;
        }

        .glass-card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
            margin-top: 30px;
        }

        .dashboard-card {
            transition: transform 0.2s ease-in-out;
        }

        .dashboard-card:hover {
            transform: scale(1.03);
        }

        h1,
        h5 {
            font-weight: 600;
        }

        .navbar {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .footer {
            margin-top: auto;
            text-align: center;
            padding: 20px;
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- 🔷 Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-2">
                    <li class="nav-item"><a class="nav-link" href="class_arrival_confirmation.php"><i
                                class="bi bi-check2-circle"></i> Class Arrival</a></li>
                    <li class="nav-item"><a class="nav-link" href="view_arrival_reports.php"><i
                                class="bi bi-journal-check"></i> Arrival Reports</a></li>
                    <li class="nav-item"><a class="nav-link" href="send_notification.php"><i
                                class="bi bi-envelope-fill"></i> Send Notification</a></li>
                    <li class="nav-item"><a class="nav-link" href="view_parents.php"><i class="bi bi-people-fill"></i>
                            Parents</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i>
                            Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- 🔹 Main Content -->
    <div class="container glass-card">
        <div class="text-center mb-4">
            <h1 class="mt-4">📚 Welcome Admin</h1>

        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card h-100 text-center shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-people-fill display-4 text-primary"></i>
                        <h5 class="mt-3">Manage Parents</h5>
                        <p>Add, edit, or view parent records.</p>
                        <a href="view_parents.php" class="btn btn-outline-primary">Go</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card h-100 text-center shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-envelope-paper-fill display-4 text-success"></i>
                        <h5 class="mt-3">Send Notification</h5>
                        <p>Email or notify parents easily.</p>
                        <a href="send_notification.php" class="btn btn-outline-success">Go</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card h-100 text-center shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-check-circle display-4 text-info"></i>
                        <h5 class="mt-3">Confirm Arrivals</h5>
                        <p>Confirm which students arrived.</p>
                        <a href="class_arrival_confirmation.php" class="btn btn-outline-info">Go</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card h-100 text-center shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-journal-text display-4 text-dark"></i>
                        <h5 class="mt-3">View Arrival Reports</h5>
                        <p>View all past arrival confirmations.</p>
                        <a href="view_arrival_reports.php" class="btn btn-outline-dark">Go</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔻 Footer -->
    <div class="footer bg-white shadow-sm mt-5">
        &copy; <?= date("Y") ?> Kiriti Girls System — All rights reserved.
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>