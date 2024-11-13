<?php
require_once "./models/VolunteerModel.php";

class VolunteerController extends RegisteredUser{
    private $volunteer;

    public function __construct($volunteerId, $skills = []) {
        $this->volunteer = new VolunteerModel($volunteerId, $skills);
    }

    // Display the list of available events by fetching them through Volunteer
    public function displayAvailableEvents() {
        $events = $this->volunteer->fetchAvailableEvents();

        // Display the events
        if (is_array($events) && !empty($events)) {
            echo "Available Events:<br>";
            foreach ($events as $event) {
                echo "Event ID: " . $event->getEventId() . ", Date: " . $event->getDate() . ", Capacity: " . $event->getEventAttendanceCapacity() . "<br>";
            }
        } else {
            echo "No available events at the moment.";
        }
    }

    // Apply for a specific event
    public function applyForEvent($eventId) {
        $result = $this->volunteer->applyForEvent($eventId);
        echo $result;
    }
}