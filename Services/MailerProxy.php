<?php
require_once $_SERVER['DOCUMENT_ROOT']."/Services/EmailService.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/IMailer.php";

class MailerProxy implements IMailer {
    private $realMailer;

    public function __construct(EmailService $mailer) {
        $this->realMailer = $mailer;
    }

    public function sendEmail($toemail, $subject, $body): bool {
        // Log email sending details
        $this->log("Attempting to send email to: $toemail with subject: $subject");

        // Delegate the task to the real mailer
        $success = $this->realMailer->sendEmail($toemail, $subject, $body);

        // Log the result
        if ($success) {
            $this->log("Email successfully sent to: $toemail");
        } else {
            $this->log("Failed to send email to: $toemail");
        }

        return $success;
    }

    private function log($message) {
        // Append log message to a file
        file_put_contents('mailer.log', date('Y-m-d H:i:s') . " - $message\n", FILE_APPEND);
    }
}
?>
