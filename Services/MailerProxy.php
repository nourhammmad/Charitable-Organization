<?php
require_once $_SERVER['DOCUMENT_ROOT']."/Services/EmailService.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/IMailer.php";

class MailerProxy implements IMailer {
    private $realMailer = null;

    public function getinstance(){
        if($this->realMailer == null){
            $realMailer = new EmailService();
        }
        return $realMailer;
    }

    public function sendEmail($toemail, $subject, $body): bool {
        $this->log("Attempting to send email to: $toemail with subject: $subject");

        $realMailer = $this->getinstance();
        // Delegate the task to the real mailer
        $success = $realMailer->sendEmail($toemail, $subject, $body);

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
