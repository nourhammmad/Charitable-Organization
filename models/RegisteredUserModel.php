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




    //CREATE DONOR
    public static function createDonor($registeredUserId, $organizationId, $donationDetails = null) {
        $donationDetails = $donationDetails ? "'$donationDetails'" : "NULL";
        $query = "INSERT INTO Donor (`registered_user_id`, `organization_id`, `donation_details`) VALUES ('$registeredUserId', '$organizationId', $donationDetails)";
        return Database::run_query($query);
    }

    public static function updateDonationDetails($donorId, $donationDetails) {
        $query = "UPDATE Donor SET `donation_details` = '$donationDetails' WHERE `id` = '$donorId'";
        return Database::run_query($query);
    }

    public static function getLastInsertDonorId() {
        $query = "SELECT `id` FROM Donor ORDER BY `id` DESC LIMIT 1;";
        $res = Database::run_select_query(query: $query);
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            return $row['id'];  
        }
        return null;  
    }

    public static function getDonorById($donorId) {
        $query = "SELECT * FROM Donor WHERE id = ?";
        $result = Database::run_select_query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Donor(
                $row['id'],
                $row['registered_user_id'],
                $row['organization_id'],
                $row['donation_details']
            );
        } else {
            return null; 
        }
    }
    
    
    
}
