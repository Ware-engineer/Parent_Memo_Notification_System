<?php
include 'config/database.php';

$sql = "SELECT * FROM parents";
$result = $conn->query($sql);

$limit = 5; // Records per page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$offset = ($page - 1) * $limit;

$search_query = "";
$params = [];

if (!empty($search)) {
    $search_query = "WHERE full_name LIKE ? OR email LIKE ? OR phone LIKE ?";
    $param = "%$search%";
    $params = [$param, $param, $param];
}

// Count total records
$count_sql = "SELECT COUNT(*) AS total FROM parents $search_query";
$stmt = $conn->prepare($count_sql);
if (!empty($params)) {
    $stmt->bind_param(str_repeat("s", count($params)), ...$params);
}
$stmt->execute();
$count_result = $stmt->get_result();
$total = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);

// Fetch records
$sql = "SELECT * FROM parents $search_query LIMIT ?, ?";
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $all_params = array_merge($params, [$offset, $limit]);
    $stmt->bind_param(str_repeat("s", count($params)) . "ii", ...$all_params);

} else {
    $stmt->bind_param("ii", $offset, $limit);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Parents Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Parents Records</h2>

        <form method="GET" class="mb-3 d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search parents..."
                value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <a href="add_parent.php" class="btn btn-success mb-3">+ Add New Parent</a>
        <a href="print_parents.php" class="btn btn-success mb-3">🖨️ Print Report</a>
        <a href="view_parents.php" class="btn btn-success mb-3">+ View Parents</a>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Student Name</th>
                    <th>Actions</th>

                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['full_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['student_name']) ?></td>
                        <td>
                            <a href="delete_parent.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this parent?');">Delete</a>

                            <a href="edit_parent.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning me-1">Edit</a>

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
    <a href="dashboard.php" class="btn btn-secondary w-100 mt-3">Back to Dashboard</a>
</body>

</html>