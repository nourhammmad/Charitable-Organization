<?php
require_once ('E:\brwana\Gam3a\Senoir 2\Design Patterns\Project\Charitable-Organization\Database.php');

class Donation {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getDbh();
    }

    // Create a new donation
    public function createDonation($userId, $quantity, $type) {
        $query = 'INSERT INTO Donations (donationId, userId, quantity, type) VALUES (UUID(), :userId, :quantity, :type)';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':type', $type);
        return $stmt->execute();
    }

    // Retrieve all donations
    public function getAllDonations() {
        $query = 'SELECT * FROM Donations';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update a donation
    public function updateDonation($donationId, $quantity) {
        $query = 'UPDATE Donations SET quantity = :quantity WHERE donationId = :donationId';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':donationId', $donationId);
        $stmt->bindParam(':quantity', $quantity);
        return $stmt->execute();
    }

    // Delete a donation
    public function deleteDonation($donationId) {
        $query = 'DELETE FROM Donations WHERE donationId = :donationId';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':donationId', $donationId);
        return $stmt->execute();
    }
}
