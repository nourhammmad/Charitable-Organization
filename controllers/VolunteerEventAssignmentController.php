<?php
$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server."\models\VolunteerEventAssignmentModel.php";
require_once $server."\models\VolunteerModel.php";
require_once $server."\controllers\VolunteerController.php";
require_once $server."\Services\Volunteer.php";



class VolunteerEventAssignmentController {

    // Method to fetch and display all available events
    public function getAvailableEvents() {
        // Fetch events from the model
        $events = VolunteerEventAssignementModel::fetchAllEvents();
    
        // Ensure fetchAllEvents() is returning an array and not a string
        if (is_array($events) && !empty($events)) {
            return $events;
        } else {
            return [];  // Return an empty array if no events
        }
    }
    

// Method to assign a volunteer to a specific event
public function assignVolunteer($volunteerId, $eventId) {
    // Check if the volunteer is already assigned to the event
    if (VolunteerModel::isVolunteerAssignedToEvent($volunteerId, $eventId)) {
        return "You are already assigned to this event.";
    }

    // Proceed with assignment if not already assigned
    $result = VolunteerEventAssignementModel::assignVolunteerToEvent($volunteerId, $eventId);

    // Return a success or failure message
    return $result ? "You have successfully applied for the event." : "Failed to apply for the event.";
}

}