<?php
require_once "./Database.php";

class UserModel {


    // private function __construct($properties)
    // {
    //     foreach ($properties as $prop => $value) {
    //         $this->{$prop} = $value;
    //     }
    // }

    // private static function getDb() {
    //     return (new Database())->getDbh();
    // }


    // FARAH:: i added this func to be the defualt here with no username or password 
    public static function createDefaultUser($id,$types): bool{
        // return run_query("INSERT INTO $configs->DB_NAME.$configs->DB_CART_ITEMS_TABLE (`cart_id`, `item_id`, `quantity`) VALUES ($cart_id, $item_id, 1)")
        
        $query = "INSERT INTO Users (`id`, `types`) VALUES ('$id','$types')";
        $res =Database::run_query(query:$query);
        echo $res;
        return $res;
    }

    // // Create a new user
    // public static function createUser($userName, $password, $type) {
    //     $db = self::getDb();
    //     $query = 'INSERT INTO Users (userName, password, type) VALUES (:userName, :password, :type)';
    //     $stmt = $db->prepare($query);
    //     $stmt->bindParam(':userName', $userName);
    //     $stmt->bindParam(':password', $password);
    //     $stmt->bindParam(':type', $type);
    //     return $stmt->execute();
    // }

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


