<?php

require_once $_SERVER['DOCUMENT_ROOT']."\Database.php";

class SMSModel {
    public function getUserByPhoneNumber($phoneNumber) {
        $query = "
            SELECT id 
            FROM RegisteredUserType
            WHERE phone = '$phoneNumber'
            LIMIT 1
        ";
        $result = Database::run_select_query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['id'];  
        }
    

        return null;
    }
    
   

  
    
    public function saveSMS($senderId, $recipientId, $message) {
        $query = "
            INSERT INTO sms_logs (sender_id, recipient_id, message, status)
            VALUES ('$senderId', '$recipientId', '$message', 'sent')
        ";
      $result = Database::run_query($query);
      return $result;
    }

    public function getAllSMSLogs() {
        $query = "
            SELECT 
                s.id AS sms_id,
                s.sender_id,
                s.recipient_id,
                s.message,
                s.status,
                s.created_at
            FROM 
                sms_logs s
            ORDER BY 
                s.created_at DESC
        ";
        $result = Database::run_select_query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;  
        }
        return [];
    }

  
    public function getSMSLogsByUser($userId) {
        $query = "
            SELECT 
                s.id AS sms_id,
                s.sender_id,
                s.recipient_id,
                s.message,
                s.status,
                s.created_at
            FROM 
                sms_logs s
            WHERE 
                s.recipient_id = '$userId'
            ORDER BY 
                s.created_at DESC
        ";
        $result = Database::run_select_query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;  
        }
        return [];
    }

   
    public function doesUserExist($userId) {
        $query = "SELECT COUNT(*) FROM RegisteredUserType WHERE id = '$userId'";
        $result = Database::run_select_query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;  
        }
        return false;
    }
}
