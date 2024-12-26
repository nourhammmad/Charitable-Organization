<?php

$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server."/Database.php";
require_once $server."/models/UserModel.php";
require_once $server."/Services/Notification.php";


class RegisterUserTypeModel {

    public static function getNotifications($recipientId) {
        // Prepare the query to fetch notifications and join with sender details
        $query = "
           SELECT 
    sms_logs.id AS notification_id,
    sms_logs.recipient_id,
    sms_logs.message,
    sms_logs.created_at,
    sms_logs.sender_id,
    registeredusertype.userName AS sender_name
FROM 
    sms_logs
LEFT JOIN 
    registeredusertype ON sms_logs.sender_id = registeredusertype.id
WHERE 
    sms_logs.recipient_id = '$recipientId'
ORDER BY 
    sms_logs.created_at DESC;

        ";
    
        // Execute the query with the recipient ID
        $result = Database::run_select_query($query, [$recipientId]);
    
        // Check if the query execution was successful
        if ($result === false) {
            return []; // Return an empty array if the query fails
        }
    
        // Initialize an array to store notification objects
        $notifications = [];
    
        // Fetch each row from the result set
        while ($row = $result->fetch_assoc()) {
            $notifications[] = new Notification(
                $row['notification_id'],  // Notification ID
                $row['recipient_id'],     // Recipient ID
                $row['message'],          // Message content
                $row['created_at'],       // Timestamp
                $row['sender_id'],        // Sender ID
                $row['sender_name']       // Sender Name
            );
        }
    
        // Return all notifications
        return $notifications;
    }
    

        // // Check if notifications were found
        
        // if (count($notifications) > 0) {
        //     // Return the notifications as a JSON response with success
        //    // echo count($notifications);
        //   // echo $notifications[0]->message;
        //   $i=0;
        //   while($i<count($notifications)){
        //     return json_encode([
        //         'success' => true,
        //         'notifications' => $notifications[0]->message
        //     ]);
        //     $i++;
        // }
        // } else {
        //     // If no notifications are found, return a failure message
        //     return json_encode([
        //         'success' => false,
        //         'message' => 'No notifications found.'
        //     ]);
        // }
    
    


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
