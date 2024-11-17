<?php
require_once './Database.php';
require_once "./models/EventModel.php";

class EventManagementController{

    public function createEvent($event) {
        return EventModel::createEvent(
            $event->date,
            $event->eventname,
            $event->addressId,
            $event->EventAttendanceCapacity,
            $event->tickets,
            $event->event_type_id
        );
    }

    public function trackEvents($events) {
        foreach ($events as $event) {
            echo "Tracking event: {$event->eventId}<br>";
        }
    }

    public function handleEventRegistration($event, $volunteerId) {
        // Step 1: Check remaining capacity
        $remainingCapacity = $event->EventAttendanceCapacity - count($event->showEventCapacity());
        if ($remainingCapacity <= 0) {
            echo "Registration failed: Event is at full capacity.<br>";
            return false;
        }
         // Step 2: Check if volunteer is already registered
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
        // Step 1: Check if tickets are available
        $availableTickets = $event->tickets;
        if ($ticketsRequested > $availableTickets) {
            echo "Ticket purchase failed: Not enough tickets available.<br>";
            return false;
        }
    
        // Step 2: Deduct requested tickets from available tickets
        $event->tickets -= $ticketsRequested;
    
        // Step 3: Update the database with the new ticket count
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
        // Step 1: Check if the volunteer is registered for the event
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
    
        // Step 2: Mark the volunteer as attended (example: updating attendance status in the database)
        $query = "UPDATE EventVolunteer SET attended = 1 WHERE eventId = {$event->eventId} AND volunteerId = {$volunteerId}";
        if (Database::run_query($query)) {
            echo "Attendance recorded successfully for Volunteer ID: {$volunteerId}.<br>";
            return true;
        } else {
            echo "Attendance tracking failed: Database error.<br>";
            return false;
        }
    }

    public function sendEventReminders($events) {
        foreach ($events as $event) {
            $event->sendReminder();
        }
    }


}


