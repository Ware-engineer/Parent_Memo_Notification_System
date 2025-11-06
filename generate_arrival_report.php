<?php
require_once('tcpdf/tcpdf.php');
require_once('config/database.php');

if (!isset($_GET['class']) || empty($_GET['class'])) {
    die('Class not specified.');
}

$class = $_GET['class'];

// Fetch confirmed arrivals for the selected class
$stmt = $conn->prepare("
    SELECT ac.student_name, p.email, ac.arrival_date 
    FROM arrival_confirmations ac
    INNER JOIN parents p ON ac.student_name = p.student_name
    WHERE p.class = ?
    ORDER BY ac.arrival_date DESC
");
$stmt->bind_param("s", $class);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("No arrival confirmations found for $class.");
}

// Create new PDF document
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Kiriti Girls System');
$pdf->SetTitle("Arrival Report - $class");
$pdf->SetMargins(15, 15, 15);
$pdf->AddPage();

// Title
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, "Student Arrival Report - $class", 0, 1, 'C');
$pdf->Ln(4);

// Table Header
$html = '<style>
            th {background-color: #f2f2f2; font-weight: bold;}
            table {border-collapse: collapse; width: 100%;}
            td, th {border: 1px solid #aaa; padding: 8px;}
        </style>
        <table>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Parent Email</th>
                <th>Arrival Date</th>
            </tr>';

$count = 1;
while ($row = $result->fetch_assoc()) {
    $html .= '<tr>
                <td>' . $count++ . '</td>
                <td>' . htmlspecialchars($row['student_name']) . '</td>
                <td>' . htmlspecialchars($row['email']) . '</td>
                <td>' . date('d M Y, h:i A', strtotime($row['arrival_date'])) . '</td>
              </tr>';
}
$html .= '</table>';

$pdf->SetFont('helvetica', '', 11);
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF
$pdf->Output("Arrival_Report_$class.pdf", 'I');
