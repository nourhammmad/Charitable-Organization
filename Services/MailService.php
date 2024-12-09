<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

class MailService {
    private $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);
        $this->setup();
    }

    private function setup() {
        $this->mailer->isSMTP();
        $this->mailer->Host       = 'smtp.gmail.com'; // Your SMTP host
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = 'your_email@gmail.com'; // Your email
        $this->mailer->Password   = 'your_app_specific_password'; // App-specific password
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port       = 587;
    }

    public function sendUserEmail($userEmail, $toEmail, $subject, $message) {
        try {
            $this->mailer->setFrom('your_email@gmail.com', 'Your Website'); // System email
            $this->mailer->addAddress($toEmail); // Recipient
            $this->mailer->addReplyTo($userEmail); // User email as the "Reply-To"
            
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $message;

            $this->mailer->send();
            return 'Email sent successfully';
        } catch (Exception $e) {
            return "Email could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }
    }
}

// Example usage
$mailService = new MailService();

$userEmail = 'shesra147@gmail.com'; // Registered user's email
$toEmail = 'nohatarekhassan@gmail.com'; // Recipient's email
$subject = 'Message from a User';
$message = '<p>This is a test message from a user.</p>';

$result = $mailService->sendUserEmail($userEmail, $toEmail, $subject, $message);
echo $result;
