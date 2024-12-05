<?php

$server=$_SERVER['DOCUMENT_ROOT'];
require_once "./Database.php";
require_once "./models/UserModel.php";


class RegisterUserTypeModel {


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
