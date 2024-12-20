<?php

$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server."\Database.php";
require_once $server.'\Services/IService.php';
// Database::getInstance();
// try {
//     $db =  Database::getInstance();
//     //Populate::populate();
// } catch (Exception $e) {
//     echo "Error initializing Database: " . $e->getMessage();
//     exit;
// }


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
    public static function createEvent($eventName, $date, $EventAttendanceCapacity, $tickets, $event_type_id) {
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
        $query = "INSERT INTO Event (`eventName`, `date`, `addressId`, `EventAttendanceCapacity`, `tickets`, `event_type_id`) 
                  VALUES ('$eventName', '$date', (SELECT addressId FROM Address LIMIT 1), '$EventAttendanceCapacity', '$tickets', '$event_type_id')";
        // Execute the query
        $result = Database::run_query($query);
    
        // Check if the query executed successfully
        if ($result) {
            
            // Use the new method to get the last inserted ID
            $lastInsertId = Database::get_last_inserted_id();
    
            if ($lastInsertId) {
                // Return the last inserted ID for further use
                return $lastInsertId;
            } else {
                return false;  // No valid event ID retrieved
            }
        } else {
            return false;  // Event creation failed
        }
    }
    
    public static function CreateFamilyShelterEvent($eventName, $date, $EventAttendanceCapacity, $tickets, $numberOfShelters, $shelterLocation, $capacity, $AccessLvl=0) {
        $event_type_id=2;
        // Step 1: Create the event using the existing createEvent method
        $eventId = self::createEvent($eventName, $date, $EventAttendanceCapacity, $tickets, $event_type_id);
    
        // If event creation was successful (i.e., $eventId is returned)
        if ($eventId) {
            // Step 2: Insert into the FamilyShelterEvent table, including AccessLvl
            $insertFamilyShelterEventQuery = "INSERT INTO FamilyShelterEvent (`eventId`, `numberOfShelters`, `shelterLocation`, `capacity`, `AccessLevel`, `event_type_id`)
                VALUES ($eventId, $numberOfShelters,(SELECT addressId FROM Address LIMIT 1) , $capacity, $AccessLvl, $event_type_id);
            ";
            
            // Run the query to insert into the FamilyShelterEvent table
            if (Database::run_query($insertFamilyShelterEventQuery)) {
                return true;  // Return true if both queries were successful
            }
        }
    
        // Return false if either event creation or family shelter event insertion fails
        return false;
    }
    
    public static function CreateEducationalCenters($eventName, $date, $EventAttendanceCapacity, $tickets, $numberOfShelters, $capacity, $AccessLvl=0) {
        $event_type_id=3;
        // Step 1: Create the event using the existing createEvent method
        $eventId = self::createEvent($eventName, $date, $EventAttendanceCapacity, $tickets, $event_type_id);
        echo "$eventId";
        // If event creation was successful (i.e., $eventId is returned)
        if ($eventId) {
            // Step 2: Insert into the FamilyShelterEvent table, including AccessLvl
            $insertEducationalCenterEventQuery = "INSERT INTO educationalcenterevent (`eventId`, `numberOfCenters`, `centerLocation`, `AccessLevel`, `event_type_id`)
                VALUES ('$eventId', '$numberOfShelters',(SELECT addressId FROM Address LIMIT 1), '$AccessLvl', '$event_type_id');
            ";
  // Run the query to insert into the FamilyShelterEvent table
  if (Database::run_query($insertEducationalCenterEventQuery)) {
    return true;  // Return true if both queries were successful
}
}
// Return false if either event creation or family shelter event insertion fails
return false;
}

    public static function CreateFoodBankEvent($eventName, $date, $EventAttendanceCapacity, $tickets, $foodQuantity, $foodType, $AccessLvl=0) {
        $event_type_id=1;
 
        $eventId = self::createEvent($eventName, $date, $EventAttendanceCapacity, $tickets, $event_type_id);
        echo "$eventId";
        if ($eventId) {
 
            $insertFoodBankEventQuery = "INSERT INTO FoodBankEvent (`eventId`, `foodQuantity`, `foodType`, `foodBankLocation`, `AccessLevel`, `event_type_id`)
                VALUES ('$eventId', '$foodQuantity','$foodType',(SELECT addressId FROM Address LIMIT 1), '$AccessLvl', '$event_type_id');
            ";
           
            // Run the query to insert into the FamilyShelterEvent table
            if (Database::run_query($insertFoodBankEventQuery)) {
                return true;  // Return true if both queries were successful
            }
        }
   
        // Return false if either event creation or family shelter event insertion fails
        return false;
    }

    public static function CreateFoodBank($eventName, $date, $EventAttendanceCapacity, $tickets, $numberOfShelters, $capacity, $AccessLvl=0) {
        $event_type_id=1;

        // Step 1: Create the event using the existing createEvent method
        $eventId = self::createEvent($eventName, $date, $EventAttendanceCapacity, $tickets, $event_type_id);
    echo "$eventId";
        // If event creation was successful (i.e., $eventId is returned)
        if ($eventId) {
            // Step 2: Insert into the FamilyShelterEvent table, including AccessLvl
            $insertFamilyShelterEventQuery = "INSERT INTO foodbankevent (`eventId`, `numberOfShelters`, `shelterLocation`, `capacity`, `AccessLvl`, `event_type_id`)
                VALUES ('$eventId', '$numberOfShelters',(SELECT addressId FROM Address LIMIT 1), '$capacity', '$AccessLvl', '$event_type_id');
            ";
            
            // Run the query to insert into the FamilyShelterEvent table
            if (Database::run_query($insertFamilyShelterEventQuery)) {
                return true;  // Return true if both queries were successful
            }
        }
    
        // Return false if either event creation or family shelter event insertion fails
        return false;
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
    public static function updateEvent($eventId, $eventName, $date, $addressId, $EventAttendanceCapacity, $tickets) {
        if (Database::get_connection() === null) {
            echo "No database connection established.";
            return false;
        }
    
        $currentEvent = self::getEventById($eventId);
        if (!$currentEvent) {
            echo "Event not found.<br>";
            return false;
        }
    
        $changes = [];
        if ($currentEvent['eventName'] !== $eventName) {
            $changes[] = "Event name changed from '{$currentEvent['eventName']}' to '$eventName'";
        }
        if ($currentEvent['date'] !== $date) {
            $changes[] = "Date changed from '{$currentEvent['date']}' to '$date'";
        }
        if ($currentEvent['addressId'] !== $addressId) {
            $changes[] = "Address changed from '{$currentEvent['addressId']}' to '$addressId'";
        }
        if ($currentEvent['EventAttendanceCapacity'] != $EventAttendanceCapacity) {
            $changes[] = "Capacity changed from '{$currentEvent['EventAttendanceCapacity']}' to '$EventAttendanceCapacity'";
        }
        if ($currentEvent['tickets'] != $tickets) {
            $changes[] = "Tickets changed from '{$currentEvent['tickets']}' to '$tickets'";
        }
    
        if (empty($changes)) {
            echo "No changes to update.<br>";
            return true;
        }
    
        $query = "UPDATE Event 
                  SET eventName = '$eventName', date = '$date', addressId = '$addressId', EventAttendanceCapacity = '$EventAttendanceCapacity', tickets = '$tickets'
                  WHERE eventId = $eventId";
        $result = Database::run_query($query);
    
        if (!$result) {
            echo "Failed to update the event.<br>";
            return false;
        }
    
        $message = "The following changes were made to the event: " . implode(', ', $changes);
        $eventInstance = new  self($eventId, $eventName,$date, $addressId, $EventAttendanceCapacity, $tickets, $currentEvent['createdAt'], $currentEvent['event_type_id']);
        $eventInstance->notifyObservers($message);
    
        return true;}
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
        $query = "INSERT INTO EventVolunteer (eventId, volunteerId) 
                  VALUES ($eventId, $volunteerId)";
        return Database::run_query($query);

        $result = Database::run_query($query);

        // Check if the insertion was successful
        if ($result) {
            // Call addObserver if insertion is successful
            self::addObserver($eventId, $volunteerId);
}

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

$eventName = "Winter Family Shelter Event";
$date = "2024-12-10";
$EventAttendanceCapacity = 100;
$tickets = 50;
$event_type_id = 1;  // Example event type ID
$numberOfShelters = 5;
$shelterLocation = "123 Shelter St.";
$capacity = 100;
$facilities = "Heating, food, beds";
//$AccessLvl = 2;  // Example access level

// Create the FamilyShelterEvent
// $success = EventModel::CreateFamilyShelterEvent($eventName, $date, $EventAttendanceCapacity, $tickets, $numberOfShelters, $shelterLocation, $capacity);

// if ($success) {
//     echo "Family Shelter Event created successfully.";
// } else {
//     echo "Failed to create Family Shelter Event.";
// }


// Ensure database connection is established
//$db = Database::getInstance();
// if (Database::get_connection() === null) {
//     echo "No database connection established.";
//     exit;
// }

// // Example of Address ID from the Address table (make sure this addressId exists in your DB)
// $addressId = '29959131-9d80-11ef-b1d4-902e1627f5db  ';  // Replace this with an actual UUID from the Address table
// $date = '$2024-12-01';
// $EventAttendanceCapacity = 100;
// $tickets = 50;

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