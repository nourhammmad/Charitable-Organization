<?php
require_once $_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/IMailer.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService implements IMailer{

function sendEmail($toemail , $subject, $body){
   $mail = new PHPMailer(true);
   try {
    $mail->isSMTP();                               
    $mail->Host = 'smtp.gmail.com';                              
    $mail->SMTPAuth = true;                                      
    $mail->Username = 'shesra147@gmail.com';                    
    $mail->Password = 'nwde adej kewo hthx';                    
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;                                         

    $mail->setFrom('Organization@gmail.com');
    $mail->addAddress($toemail); 
    // Content
    $mail->isHTML(true);                            
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = $body;

    $mail->send();
    echo 'Message has been sent';
    return true;
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    return false;
}
    }
}
?>
