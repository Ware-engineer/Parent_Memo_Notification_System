<?php
require_once('tcpdf/tcpdf.php');
include 'config/database.php';

if (!isset($_GET['class'])) {
    die("Class not specified.");
}

$class = $_GET['class'];
$stmt = $conn->prepare("SELECT full_name, email, phone, student_name FROM parents WHERE class = ?");
$stmt->bind_param("s", $class);
$stmt->execute();
$result = $stmt->get_result();

// Create new PDF
$pdf = new TCPDF();
$pdf->AddPage();

// Title
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, "Parent List - $class", 0, 1, 'C');

// Table Header
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(45, 10, "Parent Name", 1);
$pdf->Cell(55, 10, "Email", 1);
$pdf->Cell(30, 10, "Phone", 1);
$pdf->Cell(50, 10, "Student Name", 1);
$pdf->Ln();

// Table Rows
$pdf->SetFont('helvetica', '', 11);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(45, 10, $row['full_name'], 1);
    $pdf->Cell(55, 10, $row['email'], 1);
    $pdf->Cell(30, 10, $row['phone'], 1);
    $pdf->Cell(50, 10, $row['student_name'], 1);
    $pdf->Ln();
}

$pdf->Output("parents_$class.pdf", 'I');
?>