<?php

$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server."/Database.php";
require_once $server."/models/UserModel.php";
require_once $server."/Services/Notification.php";


class RegisterUserTypeModel {

    public static function getNotifications($recipientId) {
        // Prepare the query to select notifications based on recipient ID
        $query = "SELECT * FROM sms_logs WHERE recipient_id = '$recipientId'";
        $result = Database::run_select_query($query);
    
        // Check if the query returned false (error in the query)
        if ($result === false) {
            return []; // Return an empty array if no results
        }
    
        // Initialize an array to store notification objects
        $notifications = [];
    
        // Fetch each row from the result set
        while ($row = $result->fetch_assoc()) {
            // Add each notification to the array (using message from the row)
            $notifications[] = new Notification(
                $row['id'],             // Notification ID (adjust based on your db schema)
                $row['recipient_id'],   // Recipient ID
                $row['message'],        // Message content
                $row['timestamp']       // Timestamp (adjust based on your db schema)
            );
        }
    
        // Check if notifications were found
        if (count($notifications) > 0) {
            // Return the notifications as a JSON response with success
            return json_encode([
                'success' => true,
                'notifications' => $notifications
            ]);
        } else {
            // If no notifications are found, return a failure message
            return json_encode([
                'success' => false,
                'message' => 'No notifications found.'
            ]);
        }
    }
    


    public static function save($email, $userName, $passwordHash, $phone ,$category) { 
        $type = 'RegisteredUserType';
        if (UserModel::createDefaultUser($type)) {
            $userId = (String) UserModel::getLastInsertId();
            $insertRegisteredUserQuery = "INSERT INTO RegisteredUserType (`id`, `email`, `userName`, `passwordHash`,`phone`,`category`) VALUES ('$userId', '$email', '$userName', '$passwordHash','$phone' ,'$category')";
            return Database::run_query($insertRegisteredUserQuery);
        }
        return false;
    }
    

    public static function findById($id) {
        $query = "SELECT u.id AS user_id, r.id AS registered_user_id, u.created_at, r.email, r.userName 
                  FROM Users u 
                  JOIN RegisteredUserType r ON u.id = r.id 
                  WHERE u.id = '$id'";
        $result = Database::run_select_query($query);

        if ($result && $result->num_rows > 0) {
            $data = $result->fetch_assoc();
            return new RegisterUser($data['user_id'],$data['registered_user_id'], $data['email'], $data['userName'], $data['passwordHash'],$data['phone'],$data['category'] );
        }
        return null; 
    }

    public static function findByEmail($email) {
        echo "email:: ". $email;
        $query = "SELECT u.id As user_id,r.id AS registered_user_id , u.created_at, r.email, r.userName, r.category ,r.passwordHash
                  FROM Users u 
                  JOIN RegisteredUserType r ON u.id = r.id 
                  WHERE r.email = '$email' ";
        $result = Database::run_select_query($query);
      
        if ($result && $result->num_rows > 0) {
            $data = $result->fetch_assoc();
            return new RegisterUser($data['user_id'],$data['registered_user_id'], $data['email'], $data['userName'], $data['passwordHash'],$data['phone'],$data['category']);
        }
        return null; 
    }

    static public function get_by_email_and_password($email, $pass): RegisterUser|null
    {

        $rows = Database::run_select_query("SELECT r.*,u.id AS user_id FROM RegisteredUserType r
                                            JOIN Users u ON r.id = u.id 
                                            WHERE `email` = '$email' AND `passwordHash` = '$pass'");
        if ($rows->num_rows > 0) {
            $data = $rows->fetch_assoc();
            return new RegisterUser($data['user_id'],$data['id'], $data['email'], $data['userName'], $data['passwordHash'],$data['phone'],$data['category'] );
        }
        return null;
    }

    public static function getLastInsertId() {
        $query = "SELECT `id` FROM `RegisteredUserType` ORDER BY `id` DESC LIMIT 1;";
        
        $res = Database::run_select_query(query: $query);
        
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();            
            return $row['id'];
        }
        
        return null;  
    }
    



    
}
