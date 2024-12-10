<?php
//$server=$_SERVER['DOCUMENT_ROOT'];
require_once "Database.php";
require_once "models\VolunteerModel.php";
require_once "models\EventModel.php";

class VolunteerEventAssignementModel{

    // Fetch all available events from the database
    public static function fetchAllEvents() {
        $connection = Database::get_connection();
        $query = "SELECT * FROM Event";  // Adjust with the correct table name and columns

        $result = $connection->query($query);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);  // Return events as an associative array
        } else {
            return [];  // Return an empty array if no events
        }    }
   

    // Directly assign the event to the volunteer
    public static function assignVolunteerToEvent($volunteerId, $eventId) {
        
        return EventModel::addVolunteerToEvent($eventId, $volunteerId);
    
    }
    
}
