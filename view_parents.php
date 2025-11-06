<?php include 'config/database.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Parents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .accordion-button:not(.collapsed) {
            background-color: #0d6efd;
            color: white;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h3 class="mb-4">👨‍👩‍👧 View Parents by Class</h3>
        <a href="add_parent.php" class="btn btn-success mb-3">➕ Add Parent</a>

        <input type="text" id="searchInput" class="form-control mb-4" placeholder="🔍 Search parent or student name...">

        <div class="accordion" id="parentAccordion">
            <?php
            $classes = ['Form 1', 'Form 2', 'Form 3', 'Form 4'];
            foreach ($classes as $index => $form):
                $stmt = $conn->prepare("SELECT * FROM parents WHERE class = ? ORDER BY full_name");
                $stmt->bind_param("s", $form);
                $stmt->execute();
                $result = $stmt->get_result();
                $parents = $result->fetch_all(MYSQLI_ASSOC);
                ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?= $index ?>">
                        <button class="accordion-button <?= $index !== 0 ? 'collapsed' : '' ?>" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>"
                            aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $index ?>">
                            📘 <?= $form ?> (<?= count($parents) ?>)
                        </button>
                    </h2>
                    <div id="collapse<?= $index ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>"
                        aria-labelledby="heading<?= $index ?>" data-bs-parent="#parentAccordion">
                        <div class="accordion-body">
                            <?php if (count($parents) > 0): ?>
                                <div class="mb-3 d-flex justify-content-end gap-2">
                                    <a href="export_parents_pdf.php?class=<?= urlencode($form) ?>"
                                        class="btn btn-danger btn-sm">📄 Export PDF</a>
                                    <a href="export_parents_excel.php?class=<?= urlencode($form) ?>"
                                        class="btn btn-success btn-sm">📊 Export Excel</a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover parent-table">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Parent Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Student Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($parents as $row): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                                    <td><?= htmlspecialchars($row['phone']) ?></td>
                                                    <td><?= htmlspecialchars($row['student_name']) ?></td>
                                                    <td>
                                                        <a href="edit_parent.php?id=<?= $row['id'] ?>"
                                                            class="btn btn-sm btn-primary">✏️ Edit</a>
                                                        <a href="delete_parent.php?id=<?= $row['id'] ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure?')">🗑️ Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning">No parents found in <?= $form ?>.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <a href="dashboard.php" class="btn btn-secondary w-100 mt-4">⬅ Back to Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('searchInput').addEventListener('input', function () {
            const value = this.value.toLowerCase();
            const tables = document.querySelectorAll('.parent-table tbody');
            tables.forEach(tbody => {
                Array.from(tbody.rows).forEach(row => {
                    const name = row.cells[0].textContent.toLowerCase();
                    const email = row.cells[1].textContent.toLowerCase();
                    const student = row.cells[3].textContent.toLowerCase();
                    row.style.display = (name.includes(value) || email.includes(value) || student.includes(value)) ? '' : 'none';
                });
            });
        });
    </script>
</body>

</html>