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
    organization.name AS sender_name
FROM 
    sms_logs
LEFT JOIN 
    organization ON sms_logs.sender_id = organization.id
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
    public static function getEmailById($id) {
        $query = "SELECT `email` FROM `RegisteredUserType` WHERE `id` = '$id' LIMIT 1";
        $result = Database::run_select_query($query);
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['email'];
        }
    
        return null; // Return null if no email is found
    }
    public static function getAllVolunteerIds() {
        // Query to select ids of all volunteers from RegisteredUserType table where category is 'Volunteer'
        $query = "SELECT `id` FROM `RegisteredUserType` WHERE `category` = 'Volunteer'";
        $result = Database::run_select_query($query);
        
        // Debugging: Check if query is successful
        if ($result === false) {
            echo "Error: " . mysqli_error(Database::get_connection());
            return [];
        }
    
        // Initialize an empty array to store volunteer IDs
        $volunteerIds = [];
    
        // Check if there are rows returned
        if ($result && $result->num_rows > 0) {
            // Loop through the result set and collect the IDs of the volunteers
            while ($row = $result->fetch_assoc()) {
                $volunteerIds[] = $row['id'];
            }
        } else {
            echo "No volunteers found with category 'Volunteer'.<br>";
        }
    
        // Print the volunteer IDs as a comma-separated string
        echo "Volunteer IDs: " . implode(", ", $volunteerIds);
        
        // Return the array of volunteer IDs (empty array if no volunteers found)
        return $volunteerIds;
    }
    
    
    
    



    
}
