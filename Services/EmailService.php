<?php
require "D:/SDP/project/Charitable-Organization/vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService{

function sendMail($toemail , $subject, $body){
   $mail = new PHPMailer(true);

   try {
    // Server settings
    $mail->isSMTP();                               
    $mail->Host = 'smtp.gmail.com';                              // Set SMTP server (e.g., smtp.gmail.com for Gmail)
    $mail->SMTPAuth = true;                                      // Enable SMTP authentication
    $mail->Username = '';                     // SMTP username
    $mail->Password = '';                     // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;                                         // TCP port for SSL (use 587 for TLS)

    // Recipients
    $mail->setFrom('Organization@gmail.com');
    $mail->addAddress($toemail); // Add a recipient

    // Content
    $mail->isHTML(true);                             // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = $body;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
    }
}
?>
