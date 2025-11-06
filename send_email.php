<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/includes/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/includes/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/includes/PHPMailer/src/Exception.php';

function sendMail($to, $subject, $body) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        // Replace with your school's Gmail and app password
        $mail->Username = 'kiritigirlshigh@gmail.com';
        $mail->Password = 'tykr snpc dnwh vlur';

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('kiritigirlshigh@gmail.com', 'Kiriti Girls');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = nl2br($body);
        $mail->AltBody = strip_tags($body);

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}
?>
