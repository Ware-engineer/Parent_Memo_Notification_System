<?php
// Include DB connection
include 'config/database.php';

// Set headers to download file as Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=notifications_list.xls");

// Fetch notifications and parent info
$sql = "
    SELECT n.subject, n.message, n.sent_at, p.full_name AS parent_name
    FROM notifications n
    JOIN parents p ON n.parent_id = p.id
    ORDER BY n.sent_at DESC
";
$result = $conn->query($sql);

// Output column headers
echo "Parent Name\tSubject\tMessage\tSent At\n";

// Output each row
while ($row = $result->fetch_assoc()) {
    echo "{$row['parent_name']}\t{$row['subject']}\t{$row['message']}\t{$row['sent_at']}\n";
}

$conn->close();
?>