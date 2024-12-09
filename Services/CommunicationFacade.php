<?php 
require_once  "D:\\engineering ASU\computer year 4\Fall 24\Software Design Patterns\CharetyOrg\Charitable-Organization-1\Services\EmailService.php";
require_once  "D:\\engineering ASU\computer year 4\Fall 24\Software Design Patterns\CharetyOrg\Charitable-Organization-1\controllers\SMScontroller.php";


class CommunicationFacade{
    static function SendAll($toemail, $subject, $body, $recipientPhoneNumber) {
        $email = new EmailService();
        $SMS = new SMScontroller();

        // Send Email
        $email->sendMail($toemail, $subject, $body);

        // Send SMS (senderId is fetched dynamically inside SMSController)
        $result = $SMS->sendSMS(null, $recipientPhoneNumber, $body);

        // Handle the result or log success/failure
        if (!$result['success']) {
            throw new Exception($result['message']);
        }
    }
  
    // static function sendSMS($recipientPhoneNumber, $message) {
    //     $SMS = new SMScontroller();

    //     // Call sendSMS directly with dynamic sender ID
    //     $result = $SMS->sendSMS(null, $recipientPhoneNumber, $message);

    //     // Handle the result or log success/failure
    //     if (!$result['success']) {
    //         throw new Exception($result['message']);
    //     }
    // }
    



}
?>