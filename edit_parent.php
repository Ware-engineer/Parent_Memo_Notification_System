<?php
include 'config/database.php';

if (!isset($_GET['id'])) {
    die("❌ Parent ID is missing.");
}

$id = $_GET['id'];

// Fetch parent details
$stmt = $conn->prepare("SELECT * FROM parents WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("❌ Parent not found.");
}

$parent = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Parent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2>Edit Parent</h2>

        <form action="process_edit_parent.php" method="POST">
            <input type="hidden" name="id" value="<?= $parent['id'] ?>">

            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="full_name" class="form-control"
                    value="<?= htmlspecialchars($parent['full_name']) ?>" required>
            </div>

            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($parent['email']) ?>"
                    required>
            </div>

            <div class="mb-3">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($parent['phone']) ?>"
                    required>
            </div>

            <div class="mb-3">
                <label>Student Name</label>
                <input type="text" name="student_name" class="form-control"
                    value="<?= htmlspecialchars($parent['student_name']) ?>" required>
            </div>

            <div class="mb-3">
                <label>Class</label>
                <input type="text" name="class" class="form-control" value="<?= htmlspecialchars($parent['class']) ?>"
                    required>
            </div>

            <button type="submit" class="btn btn-primary">Update Parent</button>
            <a href="view_parents.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>