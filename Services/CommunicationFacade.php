<?php 
require_once  "D:/SDP/project/Charitable-Organization/Services/EmailService.php";
class CommunicationFacade{
   static function Sendall($toemail, $subject, $body ){
        $email = new EmailService;
        $email->sendMail($toemail,$subject,$body);
    }
}
?>