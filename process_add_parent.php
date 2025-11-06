<?php
include 'config/database.php';

$full_name = $_POST['full_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$student_name = $_POST['student_name'];
$class = $_POST['class'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO parents (full_name, email, phone, student_name, class) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $full_name, $email, $phone, $student_name, $class);

if ($stmt->execute()) {
    header(header: "location: view_parents.php?message-parent added successfully");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

?>