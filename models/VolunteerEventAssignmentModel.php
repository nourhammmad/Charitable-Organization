<?php
require_once "./Database.php";
require_once "./models/VolunteerModel.php";
require_once "./models/EventModel.php";

class VolunteerEventAssignemtnModel{

    // Fetch all available events from the database
    public static function fetchAllEvents() {
        return EventModel::getAllEvents();
    }

    // Directly assign the event to the volunteer
    public static function assignVolunteerToEvent(VolunteerModel $volunteer, $eventId) {
        // Insert the volunteer-event association
        $query = "INSERT INTO EventVolunteer (eventId, volunteerId) VALUES ('$eventId', '{$volunteer->getId()}')";
        $assignmentSuccess = Database::run_query($query);
    
        // Check if the assignment was successful
        if ($assignmentSuccess) {
            return "Volunteer assigned to event successfully!";
        } else {
            return "Failed to assign volunteer to the event.";
        }
    }
    
}