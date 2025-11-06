<?php
require_once('tcpdf/tcpdf.php');
include 'config/database.php';

if (!isset($_GET['class'])) {
    die("Class not specified.");
}

$class = $_GET['class'];

// First, get the arrival records with student names from the join
$stmt = $conn->prepare("
    SELECT p.student_name, a.parent_email, a.arrival_time
    FROM arrival_confirmations a
    JOIN parents p ON a.parent_email = p.email
    WHERE a.class = ?
    ORDER BY a.arrival_time DESC
");
$stmt->bind_param("s", $class);
$stmt->execute();
$result = $stmt->get_result();

// Cache the arrival rows to count them and to use later
$arrivals = [];
while ($row = $result->fetch_assoc()) {
    $arrivals[] = $row;
}
$arrivedCount = count($arrivals);

// Next, get the total number of students in the class from the parents table
$countStmt = $conn->prepare("SELECT COUNT(*) AS total FROM parents WHERE class = ?");
$countStmt->bind_param("s", $class);
$countStmt->execute();
$totalResult = $countStmt->get_result()->fetch_assoc();
$totalStudents = $totalResult['total'];

$notArrived = $totalStudents - $arrivedCount;

// Create new PDF document using TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document meta-information
$pdf->SetCreator('Kiriti Girls System');
$pdf->SetAuthor('Kiriti Girls Secondary');
$pdf->SetTitle('Arrival Report - ' . $class);
$pdf->SetSubject('Student Arrival Report');

// Optionally, set a header (customize as needed)
$pdf->SetHeaderData('', 0, 'Kiriti Girls Secondary School');

// Set margins and auto page breaks
$pdf->SetMargins(10, 20, 10);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(TRUE, 15);

// Set font
$pdf->SetFont('dejavusans', '', 10);

// Add a new page
$pdf->AddPage();

// Build the HTML content for the report
$html = '
<h3 style="text-align:center;">Arrival Report for ' . htmlspecialchars($class) . '</h3>
<p style="text-align:center;">
    <strong>Total Students:</strong> ' . $totalStudents . ' &nbsp;&nbsp;&nbsp;
    <strong>Arrived:</strong> ' . $arrivedCount . ' &nbsp;&nbsp;&nbsp;
    <strong>Not Arrived:</strong> ' . $notArrived . '
</p>
<br/>
<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr style="background-color:#f2f2f2;">
            <th><b>Student Name</b></th>
            <th><b>Parent Email</b></th>
            <th><b>Arrival Time</b></th>
        </tr>
    </thead>
    <tbody>';
    
// Append each arrival record as a row
foreach ($arrivals as $row) {
    $html .= '<tr>
        <td>' . htmlspecialchars($row['student_name']) . '</td>
        <td>' . htmlspecialchars($row['parent_email']) . '</td>
        <td>' . htmlspecialchars($row['arrival_time']) . '</td>
    </tr>';
}

$html .= '</tbody></table>';

// Write HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF (inline display in browser)
$pdf->Output('arrival_report_' . $class . '.pdf', 'I');
?>
