<?php

$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server."\Database.php";
require_once $server.'\Services/IObserver.php';
require_once $server.'\db-populate.php';

class Volunteer implements IObserver{
    private $id;

    public function __construct($id) {
        $this->id = $id;
 
   }

    // Getter methods
    public function getId() { return $this->id; }
    public static function notify($volunteerId) {

       $volunteerId = intval($volunteerId);    
       // Update the query to fetch notifications for the given volunteerId
       $query = "SELECT * FROM volunteer_notifications WHERE volunteer_id = $volunteerId ORDER BY created_at DESC";
       
       $result = Database::run_select_query($query);
       
       $notifications = [];
       
       // Check if the query returned results
       if ($result) {

           while ($row = $result->fetch_assoc()) {
               $notifications[] = $row;
           }
       }
   
       // Log the notifications array
       error_log("Notifications array: " . var_export($notifications, true));
   
       return $notifications;
        }

    
        
        
}
?>
