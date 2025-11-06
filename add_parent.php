<!DOCTYPE html>
<html>

<head>
    <title>Add Parent - Kiriti Girls</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Add Parent</h2>
        <form action="process_add_parent.php" method="post" class="border p-4 bg-white shadow-sm rounded">

            <div class="mb-3">
                <label class="form-label">Full Name:</label>
                <input type="text" name="full_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone:</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Student Name:</label>
                <input type="text" name="student_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Class:</label>
                <input type="text" name="class" class="form-control" required>
            </div>

            <input type="submit" value="Add Parent" class="btn btn-primary">
            <a href="dashboard.php" class="btn btn-secondary ms-2">Back to Dashboard</a>
        </form>
    </div>
</body>

</html>

