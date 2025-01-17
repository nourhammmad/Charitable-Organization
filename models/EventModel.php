<?php

$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server."\Database.php";
require_once $server.'\Services/IService.php';
require_once $server.'\models\RegisteredUserModel.php';
require_once $server.'\Services/ISubject.php';
require_once $server.'\models/VolunteerModel.php';
require_once $server.'\Services/Volunteer.php';
require_once $server.'\Services/EmailService.php';

class EventModel implements ISubject {
    private $eventId;
    private $eventName;
    private $date;
    private $addressId;
    private $EventAttendanceCapacity;
    private $tickets;
    private $createdAt;
    private $event_type_id;
    public $observers=[];
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


    static function GetAddresses() {
        $query = "SELECT addressId, CONCAT(city, ', ', street) AS fullAddress FROM address";
        $result = Database::run_Select_query($query); 
    
        if ($result) {
            $addresses = [];
    
            while ($row = mysqli_fetch_assoc($result)) {
                $addresses[] = $row;
            }
    
            // Return the array of addresses
            return $addresses;
        } else {
            // Log or handle the error as needed
            error_log("Error fetching addresses: ");
            return [];
        }
    }

    
    // Create a new event
    public static function createEvent($eventName, $date, $EventAttendanceCapacity,$address ,$tickets, $event_type_id) {
        // Ensure the database connection is established
        if (Database::get_connection() === null) {
            echo "No database connection established.";
            return false;
        }

        $query = "INSERT INTO Event (`eventName`, `date`, `addressId`, `EventAttendanceCapacity`, `tickets`, `event_type_id`) 
                  VALUES ('$eventName', '$date', '$address' , '$EventAttendanceCapacity', '$tickets', '$event_type_id')";
        // Execute the query
        $result = Database::run_query($query);
    
        // Check if the query executed successfully
        if ($result) {
    
            // Use the new method to get the last inserted ID
            $lastInsertId = Database::get_last_inserted_id();
    
            if ($lastInsertId) {
                // Return the last inserted ID for further use
                $eventData = EventModel::getEventById($lastInsertId);
                if ($eventData) {
                    // Create an EventSubject instance with the required 8 arguments
                    $event = new EventModel(
                        $eventData['eventId'], 
                        $eventData['eventName'], 
                        $eventData['date'], 
                        $eventData['addressId'], 
                        $eventData['EventAttendanceCapacity'], 
                        $eventData['tickets'], 
                        $eventData['created_at'], 
                        $eventData['event_type_id']
                    );
                    // Retrieve all volunteer IDs from RegisteredUserType
                        $volunteers = RegisterUserTypeModel::getAllVolunteerIds();
                
                        // Add all volunteers as observers by passing their IDs
                        $event->addObserver($volunteers);
                        $message = "A new event '{$eventData['eventName']}' has been created.";
                        $event->notifyObservers($message);
              
                return $lastInsertId;
            } 
        }else {
                return false;  // No valid event ID retrieved
            }
        } else {
            return false;  // Event creation failed
        }
    }
    
    public static function CreateFamilyShelterEvent($eventName, $date, $EventAttendanceCapacity, $tickets, $numberOfShelters, $shelterLocation, $capacity, $AccessLvl=0) {
        $event_type_id=2;

        $eventId = self::createEvent($eventName, $date, $EventAttendanceCapacity,$shelterLocation ,$tickets, $event_type_id);
        

        if ($eventId) {
            $insertFamilyShelterEventQuery = "INSERT INTO FamilyShelterEvent (`eventId`, `numberOfShelters`, `shelterLocation`, `capacity`, `AccessLevel`, `event_type_id`)
                VALUES ($eventId, $numberOfShelters,'$shelterLocation', $capacity, $AccessLvl, $event_type_id);
            ";
            
            // Run the query to insert into the FamilyShelterEvent table
            if (Database::run_query($insertFamilyShelterEventQuery)) {
                return true;  // Return true if both queries were successful
            }
        }
    
        // Return false if either event creation or family shelter event insertion fails
        return false;
    }
    
    public static function CreateEducationalCenters($eventName, $date, $EventAttendanceCapacity, $tickets, $numberOfShelters, $shelterLocation , $AccessLvl=0) {
        $event_type_id=3;
        // Step 1: Create the event using the existing createEvent method
        $eventId = self::createEvent($eventName, $date, $EventAttendanceCapacity,$shelterLocation , $tickets,$event_type_id);

        // If event creation was successful (i.e., $eventId is returned)
        if ($eventId) {
            // Step 2: Insert into the FamilyShelterEvent table, including AccessLvl
            $insertEducationalCenterEventQuery = "INSERT INTO educationalcenterevent (`eventId`, `numberOfCenters`, `centerLocation`, `AccessLevel`, `event_type_id`)
                VALUES ('$eventId', '$numberOfShelters','$shelterLocation', '$AccessLvl', '$event_type_id');
            ";
  // Run the query to insert into the FamilyShelterEvent table
  if (Database::run_query($insertEducationalCenterEventQuery)) {
    return true;  // Return true if both queries were successful
}
}
// Return false if either event creation or family shelter event insertion fails
return false;
}

    public static function CreateFoodBankEvent($eventName, $date, $EventAttendanceCapacity, $tickets, $foodQuantity, $foodType, $shelterLocation ,$AccessLvl=0) {
        $event_type_id=1;
 
        $eventId = self::createEvent($eventName, $date, $EventAttendanceCapacity, $shelterLocation ,$tickets, $event_type_id);
       
        if ($eventId) {
 
            $insertFoodBankEventQuery = "INSERT INTO FoodBankEvent (`eventId`, `foodQuantity`, `foodType`, `foodBankLocation`, `AccessLevel`, `event_type_id`)
                VALUES ('$eventId', '$foodQuantity','$foodType','$shelterLocation', '$AccessLvl', '$event_type_id');
            ";
           
            // Run the query to insert into the FamilyShelterEvent table
            if (Database::run_query($insertFoodBankEventQuery)) {
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
    
        // Execute the query
        $eventResult = Database::run_select_query($eventQuery);
        
        if ($eventResult && $eventResult->num_rows>0) {
            // Fetch the event details as an associative array
            return $eventResult->fetch_assoc();
        } else {
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

    
        return true;}

        public function addObserver($observers) {
        
            // Check if observers are passed as an array of volunteer IDs
            if (is_array($observers)) {
                // Loop through the array of volunteer IDs and add them as observers
                foreach ($observers as $volunteerId) {
                    // Directly add the volunteer ID to the observers list
                    $this->observers[] = $volunteerId;
                }
            } else {
                // If a single observer is passed, add it directly
                $this->observers[] = $observers;
            }
                  
        }
        
        //check on observers array 
        public function listObservers() {
            foreach ($this->observers as $observer) {
                echo "Observer ID: $observer";
            }
        }
        
        public function notifyObservers($message) {
            foreach ($this->observers as $observer) {
                echo "Observer ID: $observer , ";
                // Trim and sanitize the observer ID
                $observer = trim($observer); // Remove leading/trailing spaces
                $observer = intval($observer); // Ensure it's an integer
                
                // error_log("Processing observer ID: $observer");
                $escapedMessage = str_replace("'", "\'", $message);
        
                $query = "INSERT INTO volunteer_notifications(`volunteer_id`, `event_id`, `message`) 
                          VALUES ('$observer', '$this->eventId', '$escapedMessage')";
        
                error_log("Executing query: $query"); // Log the query for debugging.


                $result = Database::run_query($query);
                echo "result: $result";
        
                // Introduce a delay of 1 second (1,000,000 microseconds)
               
            }
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

    public static function getEventDetails($eventId) {
        // Ensure the database connection is established
        if (Database::get_connection() === null) {
            echo "No database connection established.";
            return false;
        }
    
        $query = "SELECT * FROM event WHERE eventId = '$eventId'";  // Use $eventId in the query directly
        $result = Database::run_select_query($query);
    
        // Check if the query executed successfully
        if ($result) {
            // Fetch and return the event details as an associative array
            return $result->fetch_assoc();
        } else {
            return false;  // Event not found or query failed
    }
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
?>