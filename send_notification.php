<?php include 'config/database.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Send Notification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-light">
    <div class="container mt-5 fade-in">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h4 class="card-title mb-4">📨 Send Notifications to Parents</h4>

                <!-- Filter form -->
                <form method="GET" class="row g-3 mb-3">
                    <div class="col-md-6">
                        <select name="class" class="form-select" onchange="this.form.submit()" required>
                            <option value="">-- Filter Parents by Class --</option>
                            <?php
                            $classes = ['Form 1', 'Form 2', 'Form 3', 'Form 4'];
                            foreach ($classes as $form):
                                ?>
                                <option value="<?= $form ?>" <?= (isset($_GET['class']) && $_GET['class'] == $form) ? 'selected' : '' ?>>
                                    <?= $form ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>

                <?php
                $selected_class = $_GET['class'] ?? '';
                $query = $selected_class
                    ? $conn->prepare("SELECT * FROM parents WHERE class = ?")
                    : $conn->prepare("SELECT * FROM parents");
                if ($selected_class)
                    $query->bind_param("s", $selected_class);
                $query->execute();
                $parents = $query->get_result();
                ?>

                <form action="process_notification.php" method="POST">
                    <input type="hidden" name="class" value="<?= htmlspecialchars($selected_class) ?>">

                    <?php if ($parents->num_rows > 0): ?>
                        <input type="text" id="searchInput" class="form-control mb-3"
                            placeholder="🔍 Search by name or email...">
                        <a href="view_notifications_by_class.php" class="btn btn-outline-primary mb-4">
                            📊 View Notifications Sent by Class
                        </a>

                        <div class="table-responsive fade-in">
                            <table class="table table-bordered table-hover" id="parentTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Select</th>
                                        <th>Parent Name</th>
                                        <th>Email</th>
                                        <th>Student</th>
                                        <th>Class</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $parents->fetch_assoc()): ?>
                                        <tr>
                                            <td><input type="checkbox" name="parent_ids[]" value="<?= $row['id'] ?>"></td>
                                            <td><?= htmlspecialchars($row['full_name']) ?></td>
                                            <td><?= htmlspecialchars($row['email']) ?></td>
                                            <td><?= htmlspecialchars($row['student_name']) ?></td>
                                            <td><span class="badge bg-primary"><?= htmlspecialchars($row['class']) ?></span>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning fade-in">No parents found for
                            <?= htmlspecialchars($selected_class) ?>.</div>
                    <?php endif; ?>

                    <div class="mt-4">
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="5" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-success">✉️ Send Notification</button>
                    </div>
                </form>
            </div>
        </div>


        <a href="dashboard.php" class="btn btn-secondary w-100 mt-4">⬅ Back to Dashboard</a>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        searchInput?.addEventListener('input', () => {
            const filter = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll("#parentTable tbody tr");

            rows.forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();
                row.style.display = (name.includes(filter) || email.includes(filter)) ? '' : 'none';
            });
        });
    </script>

</body>

</html>