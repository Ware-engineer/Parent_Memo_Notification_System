<?php include 'config/database.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications by Class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h4 class="mb-4">📨 View Notifications Sent by Class</h4>

    <form method="GET" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <select name="class" class="form-select" onchange="this.form.submit()" required>
                    <option value="">-- Select Class --</option>
                    <?php
                    $classes = ['Form 1', 'Form 2', 'Form 3', 'Form 4'];
                    foreach ($classes as $classOption):
                    ?>
                        <option value="<?= $classOption ?>" <?= isset($_GET['class']) && $_GET['class'] == $classOption ? 'selected' : '' ?>>
                            <?= $classOption ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </form>

    <?php
    if (isset($_GET['class'])):
        $selected_class = $_GET['class'];
        $stmt = $conn->prepare("
            SELECT p.email, p.full_name, n.subject, n.message, n.sent_at 
            FROM notifications n 
            JOIN parents p ON n.parent_id = p.id 
            WHERE p.class = ? 
            ORDER BY n.sent_at DESC
        ");
        $stmt->bind_param("s", $selected_class);
        $stmt->execute();
        $result = $stmt->get_result();
    ?>

    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Parent Email</th>
                        <th>Student Name</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Sent At</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['full_name']) ?></td>
                        <td><?= htmlspecialchars($row['subject']) ?></td>
                        <td><?= htmlspecialchars($row['message']) ?></td>
                        <td><?= htmlspecialchars($row['sent_at']) ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">No notifications found for <?= htmlspecialchars($selected_class) ?>.</div>
    <?php endif; ?>
    <?php endif; ?>

    <a href="send_notification.php" class="btn btn-secondary mt-4">⬅ Back to Send Notification</a>
</div>

</body>
</html>
