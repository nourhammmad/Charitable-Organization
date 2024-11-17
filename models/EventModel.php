<?php

$server=$_SERVER['DOCUMENT_ROOT'];
require_once "E:\brwana\Gam3a\Senoir 2\Design Patterns\charityyy\Charitable-Organization\Database.php";
require_once 'E:\brwana\Gam3a\Senoir 2\Design Patterns\charityyy\Charitable-Organization\Services\IService.php';
Database::getInstance();

class EventModel {
    private $eventId;
    private $eventName;
    private $date;
    private $addressId;
    private $EventAttendanceCapacity;
    private $tickets;
    private $createdAt;
    private $event_type_id;
    
    private $observers=[]; 
    // Constructor
    public function __construct($eventId,$eventName,$date, $addressId, $EventAttendanceCapacity, $tickets, $createdAt,$event_type_id) {
        $this->eventId = $eventId;
        $this->eventName =$eventName;
        $this->date = $date;
        $this->addressId = $addressId;
        $this->EventAttendanceCapacity = $EventAttendanceCapacity;
        $this->tickets = $tickets;
        $this->createdAt = $createdAt;
        $this->$event_type_id=$event_type_id;
    }

    // Create a new event
    public static function createEvent($date,$eventName,$addressId,$EventAttendanceCapacity, $tickets, $event_type_id) {
        // Ensure the database connection is established
        if (Database::get_connection() === null) {
            echo "No database connection established.";
            return false;
        }
    
        // Debugging: Output the parameters being used for insertion
       // echo "Date: $date, Capacity: $EventAttendanceCapacity, Tickets: $tickets<br>";
    
        // Example static addressId (change to dynamic if needed)
        $addressId = 'hkhk';  // Static addressId or dynamically fetched
    
        // Prepare the query to insert the event into the database
        $query = "INSERT INTO Event (`date`, 'event1',`addressId`, `EventAttendanceCapacity`, `tickets`, `event_type_id`) 
              VALUES ('$date', (SELECT addressId FROM Address LIMIT 1), '$EventAttendanceCapacity', '$tickets', '$event_type_id')";
    
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
    public function addService(IService $service) {
        return $service->setEvent($this->eventId);
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
    public static function updateEvent($eventId,$eventName ,$date, $addressId, $EventAttendanceCapacity, $tickets) {
        // Ensure the connection is established
        //$db = Database::getInstance();
        if (Database::get_connection() === null) {
            echo "No database connection established.";
            return false;
        }

        // Query to update event details
        $query = "UPDATE Event 
                  SET `date` = '$date',`eventName`='$eventName' ,`addressId` = '$addressId', `EventAttendanceCapacity` = '$EventAttendanceCapacity', `tickets` = '$tickets'
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
    public function showEventCapacity() {
        return $this->EventAttendanceCapacity;
    }

        // Observer pattern methods
        public function addObserver($observer) {
            $this->observers[] = $observer;
        }
    
        public function removeObserver($observer) {
            $index = array_search($observer, $this->observers);
            if ($index !== false) {
                unset($this->observers[$index]);
                $this->observers = array_values($this->observers); // Reindex the array
            }
        }
    
        public function notifyObservers($message) {
            foreach ($this->observers as $observer) {
                $observer->update($this, $message); // Notify each observer
            }
        }
    
}

// Testing the EventModel functionality

// Ensure database connection is established
//$db = Database::getInstance();
if (Database::get_connection() === null) {
    echo "No database connection established.";
    exit;
}

///////////////////////////////////////////Test Event Model with event types//////////////////////////////
// // Test creating an event
// echo "<h3>Testing Event Creation</h3>";

// $date = '2024-12-01';
// $EventAttendanceCapacity = 200;
// $tickets = 150;
// $event_type_id = 1;// Food Bank event type
// $addressId='hkhk';
// // Create the event and check if it was successful
// $eventId = EventModel::createEvent($date,$addressId,$EventAttendanceCapacity, $tickets, $event_type_id);
// if ($eventId) {
//     echo "Event created successfully with Event ID: $eventId<br/>";
// } else {
//     echo "Failed to create event.<br/>";
// }

// Test retrieving an event by ID
// echo "<h3>Testing Retrieve Event by ID</h3>";

// $event = EventModel::getEventById($eventId);
// if ($event) {
//     echo "Event found: <br/>";
//     echo "Event ID: " . $event['eventId'] . "<br/>";
//     echo "Date: " . $event['date'] . "<br/>";
//     echo "Capacity: " . $event['EventAttendanceCapacity'] . "<br/>";
//     echo "Tickets: " . $event['tickets'] . "<br/>";
//     echo "Event Type ID: " . $event['event_type_id'] . "<br/>";
// } else {
//     echo "Event not found.<br/>";
// }

// Test updating an event
// echo "<h3>Testing Event Update</h3>";

// $newDate = '2024-12-05';
// $newEventAttendanceCapacity = 250;
// $newTickets = 200;
// $updated = EventModel::updateEvent($eventId, $newDate, 'hkhk', $newEventAttendanceCapacity, $newTickets);
// if ($updated) {
//     echo "Event updated successfully.<br/>";
// } else {
//     echo "Failed to update event.<br/>";
// }

// // Test retrieving updated event details
// echo "<h3>Testing Retrieve Updated Event</h3>";

// $updatedEvent = EventModel::getEventById($eventId);
// if ($updatedEvent) {
//     echo "Updated Event Details: <br/>";
//     echo "Date: " . $updatedEvent['date'] . "<br/>";
//     echo "Capacity: " . $updatedEvent['EventAttendanceCapacity'] . "<br/>";
//     echo "Tickets: " . $updatedEvent['tickets'] . "<br/>";
// } else {
//     echo "Error retrieving updated event.<br/>";
// }

// // Test deleting an event
// echo "<h3>Testing Event Deletion</h3>";

// $deleted = EventModel::deleteEvent($eventId);
// if ($deleted) {
//     echo "Event deleted successfully.<br/>";
// } else {
//     echo "Failed to delete event.<br/>";
// }

// // Test retrieving a deleted event
// echo "<h3>Testing Retrieve Deleted Event</h3>";

// $deletedEvent = EventModel::getEventById($eventId);
// if ($deletedEvent) {
//     echo "Deleted event found: <br/>";
//     echo "Event ID: " . $deletedEvent['eventId'] . "<br/>";
// } else {
//     echo "Event successfully deleted, no record found.<br/>";
// }
?>
