<?php
include 'config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete parent from database
    $sql = "DELETE FROM parents WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect back to parents list
        header("Location: parents.php");
        exit();
    } else {
        echo "Error deleting parent.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
$conn->close();
?>