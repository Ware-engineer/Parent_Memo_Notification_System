<?php
include 'config/database.php';
include 'send_email.php'; // Make sure this file handles PHPMailer setup

if (isset($_POST['parent_ids'], $_POST['subject'], $_POST['message'])) {
    $parent_ids = $_POST['parent_ids']; // Array of selected parent IDs
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    $errors = [];
    $successCount = 0;

    foreach ($parent_ids as $parent_id) {
        // Get parent details
        $parent_sql = $conn->prepare("SELECT email, phone FROM parents WHERE id = ?");
        $parent_sql->bind_param("i", $parent_id);
        $parent_sql->execute();
        $parent_result = $parent_sql->get_result();
        $parent = $parent_result->fetch_assoc();

        if (!$parent)
            continue;

        $email = $parent['email'];
        $phone = $parent['phone'];

        // Insert into notifications table
        $stmt = $conn->prepare("INSERT INTO notifications (parent_id, subject, message, sent_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $parent_id, $subject, $message);

        if ($stmt->execute()) {
            // Send actual email
            if (sendMail($email, $subject, $message)) {
                $successCount++;
            } else {
                $errors[] = "Failed to send email to $email";
            }
        } else {
            $errors[] = "Failed to save notification for $email: " . $stmt->error;
        }

        $stmt->close();
        $parent_sql->close();
    }

    // Display result
    echo "<div style='margin: 20px; font-family: Arial;'>";
    echo "<h4 style='color: green;'>✅ $successCount notifications sent successfully.</h4>";
    if (!empty($errors)) {
        echo "<h5 style='color: red;'>Some errors occurred:</h5><ul>";
        foreach ($errors as $err) {
            echo "<li>$err</li>";
        }
        echo "</ul>";
    }
    echo "<a href='send_notification.php' class='btn btn-secondary mt-3'>⬅ Back to Notification Page</a>";
    echo "</div>";
} else {
    echo "❌ Please fill in all fields.";
}

$conn->close();
?>