<?php
include 'config/database.php';

$parent_id = $_POST['id']; // This must come from a hidden input in your form
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$student_name = $_POST['student_name'];
$class = $_POST['class'];

// Prepare UPDATE query
$stmt = $conn->prepare("UPDATE parents SET full_name = ?, email = ?, phone = ?, student_name = ?, class = ? WHERE id = ?");
$stmt->bind_param("sssssi", $full_name, $email, $phone, $student_name, $class, $parent_id);

if ($stmt->execute()) {
    header("Location: view_parents.php?message=Parent+updated+successfully");
    exit();
} else {
    echo "Error: " . $stmt->error;
}
?>