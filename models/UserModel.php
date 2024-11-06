<?php
require_once "./Database.php";

require_once "./Database.php";
class UserModel {

    public static function createDefaultUser($id,$types): bool{        
        $query = "INSERT INTO Users (`id`, `types`) VALUES ('$id','$types')";
        $res =Database::run_query(query:$query);
        return $res;
    }

    // Retrieve a user by ID
    public static function getUserById($id) {
        $query = "SELECT * FROM Users WHERE id = $id";
        $res =Database::run_select_query(query:$query);
        return $res;
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


