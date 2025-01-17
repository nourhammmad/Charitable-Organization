<?php
$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server."\Database.php";
require_once $server."\models\VolunteerModel.php";
require_once $server."\models\EventModel.php";

class VolunteerEventAssignementModel{

    // Fetch all available events from the database
    public static function fetchAllEvents() {
        $connection = Database::get_connection();
        $query = "SELECT * FROM Event";  // Adjust with the correct table name and columns

        $result = $connection->query($query);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC); 
        } else {
            return [];  
        }    }
   

    // Directly assign the event to the volunteer
    public static function assignVolunteerToEvent($volunteerId, $eventId) {
        
        return EventModel::addVolunteerToEvent($eventId, $volunteerId);
    
    }
    
}
