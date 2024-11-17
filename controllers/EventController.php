<?php
$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server.'./Database.php';
require_once $server."./models/EventModel.php";

class EventController {

    // Create a new event
    public function createEvent($date, $EventAttendanceCapacity, $tickets) {
        $result = EventModel::createEvent($date, $addressId=NULL, $EventAttendanceCapacity, $tickets);
        if ($result) {
            echo "Event created successfully.<br/>";
        } else {
            echo "Failed to create event.<br/>";
        }
    }

    // Retrieve all events
    public function displayAllEvents() {
        $events = EventModel::getAllEvents();
        if (!empty($events)) {
            echo "Available Events:<br/>";
            foreach ($events as $event) {
                echo "Event ID: " . $event->eventId . ", Date: " . $event->date . ", Capacity: " . $event->EventAttendanceCapacity . ", Tickets: " . $event->tickets . "<br/>";
            }
        } else {
            echo "No events available.<br/>";
        }
    }

    // Retrieve a specific event by ID
    public function displayEventById($eventId) {
        $event = EventModel::getEventById($eventId);
        if ($event) {
            //echo "Event Details:<br/>";
            //echo "Event ID: " . $event->eventId . ", Date: " . $event->date . ", Capacity: " . $event->EventAttendanceCapacity . ", Tickets: " . $event->tickets . "<br/>";
        } else {
            //echo "Event not found.<br/>";
        }
    }

    // Update an existing event
    public function updateEvent($eventId, $date, $addressId, $EventAttendanceCapacity, $tickets) {
        $result = EventModel::updateEvent($eventId, $date, $addressId, $EventAttendanceCapacity, $tickets);
        if ($result) {
            echo "Event updated successfully.<br/>";
        } else {
            echo "Failed to update event.<br/>";
        }
    }

    // Delete an event by ID
    public function deleteEvent($eventId) {
        $result = EventModel::deleteEvent($eventId);
        if ($result) {
            echo "Event deleted successfully.<br/>";
        } else {
            echo "Failed to delete event.<br/>";
        }
    }

    // Assign a volunteer to an event
    public function addVolunteerToEvent($eventId, $volunteerId) {
        $result = EventModel::addVolunteerToEvent($eventId, $volunteerId);
        if ($result) {
            echo "Volunteer added to event successfully.<br/>";
        } else {
            echo "Failed to add volunteer to event.<br/>";
        }
    }

    // Display all volunteers assigned to a specific event
    public function displayVolunteersByEvent($eventId) {
        $volunteers = EventModel::getVolunteersByEvent($eventId);
        if ($volunteers && $volunteers->num_rows > 0) {
            echo "Volunteers for Event ID $eventId:<br/>";
            while ($volunteer = $volunteers->fetch_assoc()) {
                echo "Volunteer ID: " . $volunteer['volunteerId'] . "<br/>";
            }
        } else {
            echo "No volunteers found for this event.<br/>";
        }
    }
    public function displayLastInsertedEvent() {
        $event = EventModel::getLastInsertedEvent();
        
        if ($event) {
            echo "Last Inserted Event Details:<br/>";
            echo "Event ID: " . $event['id'] . "<br/>";
            echo "Event Date: " . $event['date'] . "<br/>";
            echo "Event Capacity: " . $event['EventAttendanceCapacity'] . "<br/>";
            echo "Tickets: " . $event['tickets'] . "<br/>";
        } else {
            echo "Failed to retrieve the last inserted event.<br/>";
        }
    }
    
}

// Usage example (for testing purposes)

?>
