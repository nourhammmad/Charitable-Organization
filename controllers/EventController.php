<?php
$server=$_SERVER['DOCUMENT_ROOT'];
require_once $_SERVER['DOCUMENT_ROOT']."\Database.php";
require_once $_SERVER['DOCUMENT_ROOT']."\models\EventModel.php";

class EventController {

    private $eventModel;

  

    public function __construct($eventModel) {
        $this->eventModel = $eventModel;
    }

    // Send reminders to all observers
    public function sendReminder() {
        $this->eventModel->sendReminder();
    }
    
    public static function getAllAddresses(){
       return  EventModel::GetAddresses();
    }    
}

?>
