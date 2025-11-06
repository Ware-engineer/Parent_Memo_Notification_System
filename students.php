<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'config/database.php';

// Fetch students grouped by class
$query = "SELECT class, student_name FROM parents ORDER BY class, student_name";
$result = $conn->query($query);

$students_by_class = [];
while ($row = $result->fetch_assoc()) {
    $students_by_class[$row['class']][] = $row['student_name'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Students - Kiriti Girls</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Students by Class</h2>
        <?php foreach ($students_by_class as $class => $students): ?>
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    Class: <?php echo htmlspecialchars($class); ?>
                </div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($students as $student): ?>
                        <li class="list-group-item"><?php echo htmlspecialchars($student); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
        <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>
</body>

</html>