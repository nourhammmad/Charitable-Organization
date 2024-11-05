<?php

require_once "../Database.php";
require_once "../models/UserModel.php";

class RegisterUserTypeModel {
    private $id;
    private $email;
    private $userName;
    private $passwordHash;
    private $createdAt;

    public function __construct($id, $email, $userName, $passwordHash, $createdAt) {
        $this->id = $id;
        $this->email = $email;
        $this->userName = $userName;
        $this->passwordHash = $passwordHash;
        $this->createdAt = $createdAt;
    }

    public static function save($email, $userName, $passwordHash) {
        $id = uniqid(); 
        $type = 'RegisteredUserType';
        
        if (UserModel::createDefaultUser($id,$type)) {
            $insertRegisteredUserQuery = "INSERT INTO RegisteredUserType (id, email, userName, passwordHash) VALUES ('$id', '$email', '$userName', '$passwordHash')";
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
            return new self($data['id'], $data['email'], $data['userName'], $data['passwordHash'], $data['created_at']);
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
            return new self($data['id'], $data['email'], $data['userName'], $data['passwordHash'], $data['created_at']);
        }
        return null; 
    }
}
