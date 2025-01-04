<?php
$server=$_SERVER['DOCUMENT_ROOT'];
require_once $_SERVER['DOCUMENT_ROOT']."\Database.php";
require_once $_SERVER['DOCUMENT_ROOT']."\models\EventModel.php";

class EventController {

    private $eventModel;

    public function __construct($eventModel) {
        $this->eventModel = $eventModel;
    }

    // public function showMembers() {
    //     return $this->eventModel->showMembers();
    // }


    // Add an observer (volunteer) to the event
    public function addObserver($observer) {
        $this->eventModel->addObserver($observer);
    }

    // Remove an observer (volunteer) from the event
    public function removeObserver($observer) {
        $this->eventModel->removeObserver($observer);
    }
            // Notify all observers with a message
    public function notifyObserver($message) {
        $this->eventModel->notifyObservers($message);
    }

    // Send reminders to all observers
    public function sendReminder() {
        $this->eventModel->sendReminder();
    }
    
    
}

?>
