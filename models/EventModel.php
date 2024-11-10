<?php
require_once ("./Database.php");  // Include your Database class
Database::getInstance();

class EventModel {
    private $eventId;
    private $date;
    private $addressId;
    private $EventAttendanceCapacity;
    private $tickets;
    private $createdAt;

    // Constructor
    public function __construct($eventId, $date, $addressId, $EventAttendanceCapacity, $tickets, $createdAt) {
        $this->eventId = $eventId;
        $this->date = $date;
        $this->addressId = $addressId;
        $this->EventAttendanceCapacity = $EventAttendanceCapacity;
        $this->tickets = $tickets;
        $this->createdAt = $createdAt;
    }

    // Create a new event
    public static function createEvent($date ,$EventAttendanceCapacity, $tickets) {
        // Ensure the connection is established
        //$db = Database::getInstance();
        if (Database::get_connection() === null) {
            echo "No database connection established.";
            return false;
        }
        //var_dump($addressId); // Check what addressId is being passed
        //var_dump($date, $EventAttendanceCapacity, $tickets); // Check all other parameters

        $addressId = '70ea9c2c-9f01-11ef-a964-1cbfc07800ee'; 
        // Query to insert a new event
        $query = "INSERT INTO Event (`date`, `EventAttendanceCapacity`, `tickets`) 
                  VALUES ('$date', '$EventAttendanceCapacity', '$tickets')";
        return Database::run_query($query);
    }

    // Retrieve event by ID
    public static function getEventById($eventId) {
        // Ensure the connection is established
        $db = Database::getInstance();
        if (Database::get_connection()) {
            echo "No database connection established.";
            return null;
        }

        // Query to retrieve event by ID
        $query = "SELECT * FROM Event WHERE eventId = $eventId";
        $result = Database::run_select_query($query);
        if ($result && $result->num_rows > 0) {
            $data = $result->fetch_assoc();
            return new self(
                $data['eventId'],
                $data['date'],
                $data['addressId'],
                $data['EventAttendanceCapacity'],
                $data['tickets'],
                $data['created_at']
            );
        }
        return null;
    }

    // Update an event's details
    public static function updateEvent($eventId, $date, $addressId, $EventAttendanceCapacity, $tickets) {
        // Ensure the connection is established
        //$db = Database::getInstance();
        if (Database::get_connection() === null) {
            echo "No database connection established.";
            return false;
        }

        // Query to update event details
        $query = "UPDATE Event 
                  SET `date` = '$date', `addressId` = '$addressId', `EventAttendanceCapacity` = '$EventAttendanceCapacity', `tickets` = '$tickets'
                  WHERE eventId = $eventId";
        return Database::run_query($query);
    }

    // Delete an event
    public static function deleteEvent($eventId) {
        // Ensure the connection is established
       // $db = Database::getInstance();
        if (Database::get_connection() === null) {
            echo "No database connection established.";
            return false;
        }

        // Query to delete event
        $query = "DELETE FROM Event WHERE eventId = $eventId";
        return Database::run_query($query);
    }

    // Associate a volunteer with an event
    public static function addVolunteerToEvent($eventId, $volunteerId) {
        // Ensure the connection is established
        //$db = Database::getInstance();
        if (Database::get_connection()=== null) {
            echo "No database connection established.";
            return false;
        }

        // Query to insert volunteer-event association
        $query = "INSERT INTO EventVolunteer (`eventId`, `volunteerId`) 
                  VALUES ($eventId, $volunteerId)";
        return Database::run_query($query);
    }

    // Get the event's associated volunteers
    public static function getVolunteersByEvent($eventId) {
        // Ensure the connection is established
       // $db = Database::getInstance();
        if (Database::get_connection() === null) {
            echo "No database connection established.";
            return null;
        }

        // Query to retrieve associated volunteers
        $query = "SELECT * FROM EventVolunteer WHERE eventId = $eventId";
        return Database::run_select_query($query);
    }
}

// Testing the EventModel functionality

// Ensure database connection is established
//$db = Database::getInstance();
if (Database::get_connection() === null) {
    echo "No database connection established.";
    exit;
}

// // Example of Address ID from the Address table (make sure this addressId exists in your DB)
// $addressId = '29959131-9d80-11ef-b1d4-902e1627f5db  ';  // Replace this with an actual UUID from the Address table
// $date = '$2024-12-01';
// $EventAttendanceCapacity = 100;
// $tickets = 50;

// // Test creating an event
// if (EventModel::createEvent($date, $addressId, $EventAttendanceCapacity, $tickets)) {
//     echo "Event created successfully.<br/>";
// } else {
//     echo "Failed to create event.<br/>";
// }

// // Test retrieving an event by ID (Assuming the eventId is 1)
// $eventId = 3;
// $event = EventModel::getEventById($eventId);
// if ($event) {
//     echo "Event found: " . $event->$date . "<br/>";
// } else {
//     echo "Event not found.<br/>";
// }

// Test updating an event
// $newDate = '$2024-12-05';
// $newEventAttendanceCapacity = 150;
// $newTickets = 100;
// if (EventModel::updateEvent($eventId, $newDate, $addressId, $newEventAttendanceCapacity, $newTickets)) {
//     echo "Event updated successfully.<br/>";
// } else {
//     echo "Failed to update event.<br/>";
// }

// // Test deleting an event
// if (EventModel::deleteEvent($eventId)) {
//     echo "Event deleted successfully.<br/>";
// } else {
//     echo "Failed to delete event.<br/>";
// }

// // Test associating a volunteer with the event (Assuming volunteerId = 1)
// $volunteerId = 1;
// if (EventModel::addVolunteerToEvent($eventId, $volunteerId)) {
//     echo "Volunteer added to event successfully.<br/>";
// } else {
//     echo "Failed to add volunteer to event.<br/>";
// }

// // Test getting volunteers associated with an event
// $volunteers = EventModel::getVolunteersByEvent($eventId);
// if ($volunteers && $volunteers->num_rows > 0) {
//     while ($volunteer = $volunteers->fetch_assoc()) {
//         echo "Volunteer ID: " . $volunteer['volunteerId'] . "<br/>";
//     }
// } else {
//     echo "No volunteers found for this event.<br/>";
// }
?>
