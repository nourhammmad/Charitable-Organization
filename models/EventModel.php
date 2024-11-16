<?php

$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server.'./Database.php';
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
    public static function createEvent($date, $EventAttendanceCapacity, $tickets) {
        // Ensure the database connection is established
        if (Database::get_connection() === null) {
            echo "No database connection established.";
            return false;
        }
    
        // Debugging: Output the parameters being used for insertion
       // echo "Date: $date, Capacity: $EventAttendanceCapacity, Tickets: $tickets<br>";
    
        // Example static addressId (change to dynamic if needed)
        $addressId = '70ea9c2c-9f01-11ef-a964-1cbfc07800ee';  // Static addressId or dynamically fetched
    
        // Prepare the query to insert the event into the database
        $query = "INSERT INTO Event (`date`, `addressId`, `EventAttendanceCapacity`, `tickets`) 
                  VALUES ('$date', (SELECT addressId FROM Address LIMIT 1), '$EventAttendanceCapacity', '$tickets')";
    
        // Debugging: Check if the query is being executed properly
        //echo "Executing Query: $query<br>";
    
        // Execute the query
        $result = Database::run_query($query);
    
        // Check if the query executed successfully
        if ($result) {
            // Use the new method to get the last inserted ID
            $lastInsertId = Database::get_last_inserted_id();
            //echo "Last Inserted ID: " . $lastInsertId . "<br>"; // Debugging: Check the inserted ID
            
            if ($lastInsertId) {
                // Return the last inserted ID for further use
                return $lastInsertId;
            } else {
                //echo "No valid event ID retrieved.<br>";
                return false;
            }
        } else {
            //echo "Event creation failed. Query: $query<br>";
            return false;
        }
    }
    // Method to retrieve all events
public static function getAllEvents() {
    // Ensure the database connection is established
    if (Database::get_connection() === null) {
        echo "No database connection established.";
        return false;
    }

    // Query to retrieve all events
    $query = "SELECT * FROM Event";

    // Execute the query
    $result = Database::run_select_query($query);

    // Check if the query returned any rows
    if ($result && $result->num_rows > 0) {
        // Fetch all rows as an array of associative arrays
        $events = [];
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
        return $events;
    } else {
        // Return an empty array if no events are found
        return [];
    }
}

    
    
    // Method to retrieve event details by ID
    public static function getEventById($eventId) {
        // Ensure the database connection is established
        if (Database::get_connection() === null) {
            echo "No database connection established.";
            return false;
        }
    
        // Sanitize the eventId to prevent SQL injection (important for security)
        $eventId = (int)$eventId;

        // Query to fetch event details by event ID
        $eventQuery = "SELECT * FROM Event WHERE eventId = $eventId";
    
        // Debugging: Output the query to check if it's correct
        //echo "Executing Query: $eventQuery<br>";
    
        // Execute the query
        $eventResult = Database::run_select_query($eventQuery);
        
        if ($eventResult && $eventResult->num_rows>0) {
            // Fetch the event details as an associative array
            return $eventResult->fetch_assoc();
        } else {
            // If no rows were returned, output an error message
            //echo "Error retrieving event details or no event found for ID: $eventId<br>";
            return false;
        }
    }
    
    public static function getLastInsertedEvent() {
        // Ensure the database connection is established
        if (Database::get_connection() === null) {
            echo "No database connection established.<br>";
            return false;
        }
    
        // Get the last inserted event ID
        $lastInsertId = Database::get_connection()->insert_id;
    
        // If a valid ID is returned, fetch the event details
        if ($lastInsertId) {
            // Query to fetch the last inserted event using the last insert ID
            $eventQuery = "SELECT * FROM Event WHERE id = $lastInsertId";
            $eventResult = Database::run_query($eventQuery);
    
            // Check if the query was successful and rows were returned
            if ($eventResult && $eventResult instanceof mysqli_result && $eventResult->num_rows > 0) {
                // Return the event details as an associative array
                return $eventResult->fetch_assoc();
            } else {
                echo "No event found with the last inserted ID.<br>";
                return false;
            }
        } else {
            echo "No valid event ID retrieved.<br>";
            return false;
        }
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
