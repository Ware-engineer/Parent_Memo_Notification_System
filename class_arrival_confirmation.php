<?php include 'config/database.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Class Arrival Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .fade-in {
            animation: fadeIn 0.7s ease-in-out;
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
                <h4 class="card-title mb-4">📋 Confirm Student Arrivals by Class</h4>

                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-6">
                        <select name="class" class="form-select" required>
                            <option value="">-- Select Class --</option>
                            <?php foreach (['Form 1', 'Form 2', 'Form 3', 'Form 4'] as $form): ?>
                                <option value="<?= $form ?>" <?= (isset($_GET['class']) && $_GET['class'] == $form) ? 'selected' : '' ?>>
                                    <?= $form ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">🔍 View Students</button>
                    </div>
                </form>

                <?php
                if (isset($_GET['class'])) {
                    $class = $_GET['class'];
                    $stmt = $conn->prepare("SELECT id, student_name, email FROM parents WHERE class = ?");
                    $stmt->bind_param("s", $class);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0): ?>
                        <input type="text" id="searchInput" class="form-control mb-3"
                            placeholder="🔍 Search student name or email...">

                        <form method="POST" action="process_arrival.php">
                            <input type="hidden" name="class" value="<?= htmlspecialchars($class) ?>">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered fade-in" id="studentTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Select</th>
                                            <th>Student Name</th>
                                            <th>Parent Email</th>
                                            <th>Class Badge</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><input type="checkbox" name="arrived_ids[]" value="<?= $row['id'] ?>"></td>
                                                <td><?= htmlspecialchars($row['student_name']) ?></td>
                                                <td><?= htmlspecialchars($row['email']) ?></td>
                                                <td><span class="badge bg-info text-dark"><?= htmlspecialchars($class) ?></span>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" class="btn btn-success mt-3">✅ Confirm Arrival & Notify Parents</button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning fade-in">No students found for <?= htmlspecialchars($class) ?>.</div>
                    <?php endif;
                }
                ?>
            </div>
        </div>

        <a href="dashboard.php" class="btn btn-secondary w-100 mt-4">⬅ Back to Dashboard</a>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        searchInput?.addEventListener('input', () => {
            const filter = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll("#studentTable tbody tr");

            rows.forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();
                row.style.display = (name.includes(filter) || email.includes(filter)) ? '' : 'none';
            });
        });
    </script>

</body>

</html>