<?php

require_once $_SERVER['DOCUMENT_ROOT']."\models\SMSModel.php";
require_once $_SERVER['DOCUMENT_ROOT']."\models\RegisteredUserModel.php";
require_once $_SERVER['DOCUMENT_ROOT']."\Services\RegisterUser.php";
class SMScontroller {
    private $smsModel;
 

    public function __construct() {
        $this->smsModel = new SMSModel();
       

    }

   
    public function sendSMS($senderId, $recipientPhoneNumber, $message) {
        try {
           
            if (!$this->smsModel->doesUserExist($senderId)) {
                throw new Exception("Sender ID does not exist.");
            }

           
            if (!$senderId) {
                throw new Exception("Sender  does not exist.");
            }
            if (empty($senderId) || empty($recipientPhoneNumber) || empty($message)) {
                throw new Exception("Sender, recipient phone number, and message are required.");
            }
    
    
            // Fetch recipient ID using their phone number
            $recipientId = $this->smsModel->getUserByPhoneNumber($recipientPhoneNumber);
            if (!$recipientId) {
                throw new Exception("Recipient with phone number {$recipientPhoneNumber} does not exist.");
            }
    
            // Save the SMS to the database
            $smsId = $this->smsModel->saveSMS($senderId, $recipientId, $message);
    
            return [
                'success' => true,
                'message' => "SMS sent successfully!",
                'smsId' => $smsId
            ];
        } catch (Exception $e) {
            return $this->handleError($e);
        }
    }
        public function getSMSLogs() {
        return $this->smsModel->getAllSMSLogs();
    }

   
    public function getSMSByUser($userId) {
        return $this->smsModel->getSMSLogsByUser($userId);
    }

   
    private function handleError($e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}
