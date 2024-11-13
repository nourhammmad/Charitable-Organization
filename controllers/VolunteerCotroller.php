<?php
require_once "./models/VolunteerModel.php";
require_once "./controllers/VolunteeEventAssignmentController.php.php";


class VolunteerCotroller {
    private $volunteerModel;
    private $assignEventController;

    // Initialize with a VolunteerModel instance and create an assignment controller instance
    public function __construct($volunteerId) {
        $this->volunteerModel = VolunteerModel::getVolunteerById($volunteerId);
        $this->assignEventController = new VolunteeEventAssignmentController();
    }

    public function displayAvailableEvents() {
        $events = $this->assignEventController->getAvailableEvents();
        
        if (is_array($events) && !empty($events)) {
            echo "Available Events:<br>";
            foreach ($events as $event) {
                // Use getter methods instead of array keys
                echo "Event ID: " . $event->getEventId() . ", Date: " . $event->getDate() ."<br>";
            }
        } else {
            echo "No available events at the moment.";
        }
    }
    

    public function applyForEvent($eventId) {
        if ($this->volunteerModel) {
            $result = $this->assignEventController->assignVolunteer($this->volunteerModel->getId(), $eventId);
            echo $result;
        } else {
            echo "Volunteer not found.";
        }
    }

    public function updateVolunteerSkills($skills) {
        try {
            VolunteerModel::saveSkills($this->volunteerModel->getId(), $skills);
            echo "Skills updated successfully!";
        } catch (Exception $e) {
            echo "Failed to update skills: " . $e->getMessage();
        }
    }

    public function addDescriptionToVolunteer($description) {
        $result = VolunteerModel::addDescription($description, $this->volunteerModel->getId());
        echo $result ? "Description added successfully!" : "Failed to add description.";
    }
}
