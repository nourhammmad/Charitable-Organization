<?php
require_once "./models/VolunteerEventAssignementModel.php";
require_once "./models/VolunteerModel.php";

class VolunteerAssignemtnController {

    // Method to fetch and display all available events
    public function getAvailableEvents() {
        // Fetch all events using the model
        $events = VolunteerEventAssignementModel::fetchAllEvents();
        
        if (!empty($events)) {
            return $events;
        } else {
            return "No available events at the moment.";
        }
    }

    // Method to assign a volunteer to a specific event
    public function assignVolunteer($volunteerId, $eventId) {
        // Initialize the volunteer with their ID
        $volunteer = new Volunteer($volunteerId);

        // Call the model to assign the volunteer to the event
        $result = VolunteerEventAssignementModel::assignVolunteerToEvent($volunteer, $eventId);
        
        return $result;
    }
}