<?php
interface IMailer {
     function sendEmail($toemail, $subject, $body);
}
