<?php
//$server=$_SERVER['DOCUMENT_ROOT'];
require_once "D:/SDP/project/Charitable-Organization/models/VolunteerEventAssignmentModel.php";
require_once "D:/SDP/project/Charitable-Organization/models/VolunteerModel.php";
require_once "D:/SDP/project/Charitable-Organization/controllers/VolunteerCotroller.php";
require_once "D:/SDP/project/Charitable-Organization/Services/Volunteer.php";



class VolunteeEventAssignmentController {

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
        // Ensure your database model method returns a success or failure message
        $result = VolunteerEventAssignementModel::assignVolunteerToEvent($volunteerId, $eventId);
        
        // Return a success or failure message
        return $result ? "You have successfully applied for the event." : "Failed to apply for the event.";}
}