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
    
    public static function getAllAddresses(){
       return  EventModel::GetAddresses();
    }

    // Retrieve all events
    // public function displayAllEvents() {
    //     $events = EventModel::getAllEvents();
    //     if (!empty($events)) {
    //         echo "Available Events:<br/>";
    //         foreach ($events as $event) {
    //             echo "Event ID: " . $event->eventId . ", Date: " . $event->date . ", Capacity: " . $event->EventAttendanceCapacity . ", Tickets: " . $event->tickets . "<br/>";
    //         }
    //     } else {
    //         echo "No events available.<br/>";
    //     }
    // }

    // // Retrieve a specific event by ID
    // public function displayEventById($eventId) {
    //     $event = EventModel::getEventById($eventId);
    //     if ($event) {
    //         echo "Event Details:<br/>";
    //         echo "Event ID: " . $event->eventId . ", Date: " . $event->date . ", Capacity: " . $event->EventAttendanceCapacity . ", Tickets: " . $event->tickets . "<br/>";
    //     } else {
    //         echo "Event not found.<br/>";
    //     }
    // }

    // // Update an existing event
    // public function updateEvent($eventId, $date, $addressId, $EventAttendanceCapacity, $tickets) {
    //     $result = EventModel::updateEvent($eventId, $date, $addressId, $EventAttendanceCapacity, $tickets);
    //     if ($result) {
    //         echo "Event updated successfully.<br/>";
    //     } else {
    //         echo "Failed to update event.<br/>";
    //     }
    // }

    // // Delete an event by ID
    // public function deleteEvent($eventId) {
    //     $result = EventModel::deleteEvent($eventId);
    //     if ($result) {
    //         echo "Event deleted successfully.<br/>";
    //     } else {
    //         echo "Failed to delete event.<br/>";
    //     }
    // }

    // // Assign a volunteer to an event
    // public function addVolunteerToEvent($eventId, $volunteerId) {
    //     $result = EventModel::addVolunteerToEvent($eventId, $volunteerId);
    //     if ($result) {
    //         echo "Volunteer added to event successfully.<br/>";
    //     } else {
    //         echo "Failed to add volunteer to event.<br/>";
    //     }
    // }

    // // Display all volunteers assigned to a specific event
    // public function displayVolunteersByEvent($eventId) {
    //     $volunteers = EventModel::getVolunteersByEvent($eventId);
    //     if ($volunteers && $volunteers->num_rows > 0) {
    //         echo "Volunteers for Event ID $eventId:<br/>";
    //         while ($volunteer = $volunteers->fetch_assoc()) {
    //             echo "Volunteer ID: " . $volunteer['volunteerId'] . "<br/>";
    //         }
    //     } else {
    //         echo "No volunteers found for this event.<br/>";
    //     }
    // }
    // public function displayLastInsertedEvent() {
    //     $event = EventModel::getLastInsertedEvent();
        
    //     if ($event) {
    //         echo "Last Inserted Event Details:<br/>";
    //         echo "Event ID: " . $event['id'] . "<br/>";
    //         echo "Event Date: " . $event['date'] . "<br/>";
    //         echo "Event Capacity: " . $event['EventAttendanceCapacity'] . "<br/>";
    //         echo "Tickets: " . $event['tickets'] . "<br/>";
    //     } else {
    //         echo "Failed to retrieve the last inserted event.<br/>";
    //     }
    // }
    
}

// Usage example (for testing purposes)

?>
