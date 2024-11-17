<?php
//$server=$_SERVER['DOCUMENT_ROOT'];

require_once "./Database.php";

class UserModel {

    public static function createDefaultUser($types): bool{        
        $query = "INSERT INTO Users (`types`) VALUES ('$types')";
        $res =Database::run_query(query:$query);
        return $res;
    }

    // Retrieve a user by ID
    public static function getUserById($id) {
        $query = "SELECT * FROM Users WHERE id = $id";
        $res =Database::run_select_query(query:$query);
        return $res;
    }

    public static function getLastInsertId() {
        $query = "SELECT `id` FROM `Users` ORDER BY `id` DESC LIMIT 1;";
        $res = Database::run_select_query(query: $query);
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            return $row['id'];  
        }
        return null;  
    }
    





    // // Update user information
    // public static function updateUser($id, $userName, $password) {
    //     $db = self::getDb();
    //     $query = 'UPDATE Users SET userName = :userName, password = :password WHERE id = :id';
    //     $stmt = $db->prepare($query);
    //     $stmt->bindParam(':id', $id);
    //     $stmt->bindParam(':userName', $userName);
    //     $stmt->bindParam(':password', $password);
    //     return $stmt->execute();
    // }

    // Delete a user
    public function deleteUser($id) {
            $query = "DELETE FROM Users WHERE id = $id";
            $res =Database::run_query(query:$query);
            return $res;
    }




}


