<?php 
require_once $_SERVER['DOCUMENT_ROOT']."\Services\EmailService.php";
require_once $_SERVER['DOCUMENT_ROOT']."\Services\MailerProxy.php";
require_once $_SERVER['DOCUMENT_ROOT']."\controllers\SMScontroller.php";
//require_once  "D:\\engineering ASU\computer year 4\Fall 24\Software Design Patterns\CharetyOrg\Charitable-Organization-1\Services\EmailService.php";
//require_once  "D:\\engineering ASU\computer year 4\Fall 24\Software Design Patterns\CharetyOrg\Charitable-Organization-1\controllers\SMScontroller.php";


class CommunicationFacade{
    static function SendAll($toemail, $subject, $body, $recipientPhoneNumber) {
       // $Remail = new EmailService($toemail, $subject, $body);
        $Pemail = new MailerProxy();
        $SMS = new SMScontroller();

        // Send Email
        $Pemail->sendEmail($toemail, $subject, $body);

        // Send SMS (senderId is fetched dynamically inside SMSController)
        $result = $SMS->sendSMS(1, $recipientPhoneNumber, $body);

        // Handle the result or log success/failure
        if (!$result['success']) {
            throw new Exception($result['message']);
        }
    }
  

    



}
?>