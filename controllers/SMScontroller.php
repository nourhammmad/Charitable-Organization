<?php

require_once $_SERVER['DOCUMENT_ROOT']."\models\SMSModel.php";
require_once $_SERVER['DOCUMENT_ROOT']."\models\RegisteredUserModel.php";
require_once "D:\\engineering ASU\computer year 4\Fall 24\Software Design Patterns\CharetyOrg\Charitable-Organization-1\Services\RegisterUser.php";
class SMScontroller {
    private $smsModel;
    private $registerUserService;

    public function __construct() {
        $this->smsModel = new SMSModel();
        //$this->registerUserService = new RegisterUser();

    }

   
    public function sendSMS($senderId, $recipientPhoneNumber, $message) {
        try {
            // Validate inputs
           
            // Check if sender exists
            if (!$this->smsModel->doesUserExist($senderId)) {
                throw new Exception("Sender ID does not exist.");
            }

            $senderId = RegisterUserTypeModel::getLastInsertId();
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
