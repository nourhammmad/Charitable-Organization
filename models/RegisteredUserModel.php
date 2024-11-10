<?php


require_once "F:/senior 2/Design Patterns/project/Charitable-Organization/Database.php";
require_once "F:/senior 2/Design Patterns/project/Charitable-Organization/models/UserModel.php";

class RegisterUserTypeModel {
    private $id;
    private $email;
    private $userName;
    private $passwordHash;
    private $createdAt;
    private $category;
    

    public function __construct($id,$email, $userName, $passwordHash,$category ,$createdAt) {
        $this->id =$id;
        $this->email = $email;
        $this->userName = $userName;
        $this->passwordHash = $passwordHash;
        $this->createdAt = $createdAt;
        $this->category=$category;
    }

    public static function save($email, $userName, $passwordHash, $category) { 
        $type = 'RegisteredUserType';
        if (UserModel::createDefaultUser($type)) {
            $userId = (String) UserModel::getLastInsertId();
          //  echo $userId;
            $insertRegisteredUserQuery = "INSERT INTO RegisteredUserType (`id`, `email`, `userName`, `passwordHash`, `category`) VALUES ('$userId', '$email', '$userName', '$passwordHash', '$category')";
            return Database::run_query($insertRegisteredUserQuery);
        }
        return false;
    }
    

    public static function findById($id) {
        $query = "SELECT u.id, u.created_at, r.email, r.userName 
                  FROM Users u 
                  JOIN RegisteredUserType r ON u.id = r.id 
                  WHERE u.id = '$id'";
        $result = Database::run_select_query($query);

        if ($result && $result->num_rows > 0) {
            $data = $result->fetch_assoc();
            return new self($data['id'], $data['email'], $data['userName'], $data['passwordHash'],$data['category'] ,$data['created_at']);
        }
        return null; 
    }

    public static function findByEmail($email) {
        $query = "SELECT u.id, u.created_at, r.email, r.userName, r.passwordHash 
                  FROM Users u 
                  JOIN RegisteredUserType r ON u.id = r.id 
                  WHERE r.email = '$email'";
        $result = Database::run_select_query($query);

        if ($result && $result->num_rows > 0) {
            $data = $result->fetch_assoc();
            return new self($data['id'], $data['email'], $data['userName'], $data['passwordHash'],$data['category'], $data['created_at']);
        }
        return null; 
    }

    static public function get_by_email_and_password($email, $pass): RegisterUser|null
    {

        $rows = Database::run_select_query("SELECT * FROM RegisteredUserType WHERE `email` = '$email' AND `passwordHash` = '$pass'");
        if ($rows->num_rows > 0) {
            $data = $rows->fetch_assoc();
            return new RegisterUser($data['email'], $data['userName'], $data['category']);
        }
        return null;
    }





    
    
    
}
