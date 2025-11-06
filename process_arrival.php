<?php
include 'config/database.php';
include 'send_email.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class = $_POST['class'];
    $arrived_ids = isset($_POST['arrived_ids']) ? $_POST['arrived_ids'] : [];

    if (!empty($arrived_ids)) {
        $stmt = $conn->prepare("SELECT student_name, email FROM parents WHERE id = ?");
        $insert = $conn->prepare("INSERT INTO arrival_confirmations (student_name, class, parent_email, arrival_time) VALUES (?, ?, ?, NOW())");

        foreach ($arrived_ids as $id) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $student_name = $row['student_name'];
                $parent_email = $row['email'];

                $insert->bind_param("sss", $student_name, $class, $parent_email);
                $insert->execute();

                // Send real email
                $subject = "Arrival Confirmation for $student_name";
                $message = "Dear Parent,<br><br>Your daughter <strong>$student_name</strong> has arrived in school.<br><br>Regards,<br>Kiriti Girls.";
                sendMail($parent_email, $subject, $message);
            }
        }

        echo "<script>alert('Arrival confirmed and emails sent.'); window.location.href='class_arrival_confirmation.php?class=" . urlencode($class) . "';</script>";
    } else {
        echo "<script>alert('Please select students to confirm arrival.'); window.history.back();</script>";
    }
}
?>
