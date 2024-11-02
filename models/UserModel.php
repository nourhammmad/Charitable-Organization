<?php
require_once ('E:\brwana\Gam3a\Senoir 2\Design Patterns\Project\Charitable-Organization\Database.php');

class User {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getDbh();
    }

    // Create a new user
    public function createUser($userName, $password, $type) {
        $query = 'INSERT INTO Users (userName, password, type) VALUES (:userName, :password, :type)';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':type', $type);
        return $stmt->execute();
    }

    // Retrieve a user by ID
    public function getUserById($id) {
        $query = 'SELECT * FROM Users WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update user information
    public function updateUser($id, $userName, $password) {
        $query = 'UPDATE Users SET userName = :userName, password = :password WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':password', $password);
        return $stmt->execute();
    }

    // Delete a user
    public function deleteUser($id) {
        $query = 'DELETE FROM Users WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
