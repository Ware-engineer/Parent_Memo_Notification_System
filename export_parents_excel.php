<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=parents_export.xls");

include 'config/database.php';

if (!isset($_GET['class'])) {
    die("Class not specified.");
}

$class = $_GET['class'];
$stmt = $conn->prepare("SELECT full_name, email, phone, student_name FROM parents WHERE class = ?");
$stmt->bind_param("s", $class);
$stmt->execute();
$result = $stmt->get_result();

echo "<table border='1'>";
echo "<tr>
        <th>Parent Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Student Name</th>
      </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['full_name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['phone']}</td>
            <td>{$row['student_name']}</td>
          </tr>";
}

echo "</table>";
?>