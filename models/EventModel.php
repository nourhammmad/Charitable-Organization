<?php
require_once "../Database.php";

class Event {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getDbh();
    }

    // Create a new event
    public function createEvent($date, $address, $capacity) {
        // No need to specify eventId as it will auto-increment
        $query = 'INSERT INTO Events (date, address, EventAttendanceCapacity) VALUES (:date, :address, :capacity)';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':capacity', $capacity);
        return $stmt->execute();
    }

    // Retrieve all events
    public function getAllEvents() {
        $query = 'SELECT * FROM Events';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update event details
    public function updateEvent($eventId, $date, $address, $capacity) {
        $query = 'UPDATE Events SET date = :date, address = :address, EventAttendanceCapacity = :capacity WHERE eventId = :eventId';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':eventId', $eventId);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':capacity', $capacity);
        return $stmt->execute();
    }

    // Delete an event
    public function deleteEvent($eventId) {
        $query = 'DELETE FROM Events WHERE eventId = :eventId';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':eventId', $eventId);
        return $stmt->execute();
    }
}
