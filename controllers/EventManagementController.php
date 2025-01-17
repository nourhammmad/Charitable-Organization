<?php
$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server.'\Database.php';
require_once $server."\models\EventModel.php";
require_once $server."\models\VolunteerEventAssignmentModel.php";

class EventManagementController{
    
    private $eventModel;
    

    public function __construct() {
        // Initialize the EventModel
        $this->eventModel = new EventModel(null, null, null, null, 0, 0, null, null);
    }

    public function createEvent($event) {
        return EventModel::createEvent(
            $event->date,
            $event->eventName,
            $event->addressId,
            $event->EventAttendanceCapacity,
            $event->tickets,
            $event->event_type_id
        );
        
    }


    public function getEventById($eventId) {
        return EventModel::getEventById($eventId);
    }

    // Method to update an event and notify observers
    public function updateEventAndNotify($eventId, $eventName, $date, $addressId, $EventAttendanceCapacity, $tickets) {
        // Fetch the current event
        $currentEvent = EventModel::getEventById($eventId);
        if (!$currentEvent) {
            echo "Event not found.<br>";
            return false;
        }

        // Update the event
        $updated = EventModel::updateEvent($eventId, $eventName, $date, $addressId, $EventAttendanceCapacity, $tickets);
        if (!$updated) {
            echo "Failed to update the event.<br>";
            return false;
        }

        $message = "Event {$eventName} (ID: {$eventId}) has been updated.";
        $eventInstance = new EventModel(
            $eventId,
            $eventName,
            $date,
            $addressId,
            $EventAttendanceCapacity,
            $tickets,
            $currentEvent['createdAt'],
            $currentEvent['event_type_id']
        );
  

        echo "Event updated and observers notified.<br>";
        return true;
    }

    // Method to add an observer to an event
    public function addObserver($eventId, $observer) {
        $event = EventModel::getEventById($eventId);
        if (!$event) {
            echo "Event not found.<br>";
            return false;
        }

        $eventInstance = new EventModel(
            $event['eventId'],
            $event['eventName'],
            $event['date'],
            $event['addressId'],
            $event['EventAttendanceCapacity'],
            $event['tickets'],
            $event['createdAt'],
            $event['event_type_id']
        );


        return true;
    }



    public function trackEvents($events) {
        foreach ($events as $event) {
            echo "Tracking event: {$event->eventId}<br>";
        }
    }

    public function handleEventRegistration($event, $volunteerId) {
        $remainingCapacity = $event->EventAttendanceCapacity - count($event->showEventCapacity());
        if ($remainingCapacity <= 0) {
            echo "Registration failed: Event is at full capacity.<br>";
            return false;
        }
    $volunteers = $event->getVolunteersByEvent($event->eventId);
    foreach ($volunteers as $volunteer) {
        if ($volunteer['volunteerId'] == $volunteerId) {
            echo "Registration failed: Volunteer is already registered.<br>";
            return false;
        }
    }
    if (EventModel::addVolunteerToEvent($event->eventId, $volunteerId)) {
        echo "Volunteer registered successfully.<br>";
        return true;
    } else {
        echo "Registration failed: Database error.<br>";
        return false;
    }
    }
    public function manageEventTickets($event, $ticketsRequested) {
    
        $availableTickets = $event->tickets;
        if ($ticketsRequested > $availableTickets) {
            echo "Ticket purchase failed: Not enough tickets available.<br>";
            return false;
        }
    
    
        $event->tickets -= $ticketsRequested;
    

        if (EventModel::updateEvent($event->eventId,$event->eventName,$event->date, $event->addressId, 
        $event->EventAttendanceCapacity, $event->tickets)) {
            echo "Tickets purchased successfully.<br>";
            return true;
        } else {
            echo "Ticket purchase failed: Database error.<br>";
            return false;
        }
    }
    public function trackAttendance($event, $volunteerId) {
    
        $volunteers = $event->getVolunteersByEvent($event->eventId);
        $isRegistered = false;
    
        foreach ($volunteers as $volunteer) {
            if ($volunteer['volunteerId'] == $volunteerId) {
                $isRegistered = true;
                break;
            }
        }
    
        if (!$isRegistered) {
            echo "Attendance tracking failed: Volunteer is not registered for the event.<br>";
            return false;
        }
    
        $query = "UPDATE EventVolunteer SET attended = 1 WHERE eventId = {$event->eventId} AND volunteerId = {$volunteerId}";
        if (Database::run_query($query)) {
            echo "Attendance recorded successfully for Volunteer ID: {$volunteerId}.<br>";
            return true;
        } else {
            echo "Attendance tracking failed: Database error.<br>";
            return false;
        }
    }
    public function getAvailableEvents() {

        $events = VolunteerEventAssignementModel::fetchAllEvents();
    
    
        if (is_array($events) && !empty($events)) {
            return $events;
        } else {
            return []; 
}}

public function getEventDetails($eventId){
$eventDetails = EventModel::getEventDetails($eventId);


if ($eventDetails) {
    return $eventDetails;
} else {
    return ['message' => 'Event not found or error retrieving data.'];
}
}

}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $action = isset($_GET['action']) ? $_GET['action'] : null;

    $handler = new EventManagementController();

    if ($action === 'getEvents') {
        $events = $handler->getAvailableEvents();
        
        if (empty($events)) {
            echo json_encode(['message' => 'No events available.']);
        } else {
            echo json_encode(['events' => $events]);
        }
    }
 
    
       else if ($action === 'getEventDetails') {
            $eventId = isset($_GET['eventId']) ? $_GET['eventId'] : null;
            if ($eventId) {
                $event = $handler->getEventDetails($eventId);
        
                // Convert to JSON response
                echo json_encode(['event' => $event]);
            } else {
                echo 'Event ID is missing.';
            }
        }


}




?>


