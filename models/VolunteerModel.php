<?php
require_once "./models/RegisteredUserModel.php";
require_once "./controllers/VolunteerAssignemtnController.php";

class VolunteerModel extends RegisterUserModel {
    private $skills;
    private $assignEventController;

    public function __construct($id, $email, $userName, $passwordHash, $category, $createdAt, $skills = []) {
        // Pass all required parameters to the parent constructor
        parent::__construct($id, $email, $userName, $passwordHash, $category, $createdAt);
        
        // Initialize Volunteer-specific attributes
        $this->skills = $skills;
        $this->assignEventController = new VolunteerAssignemtnController();
    }

    // Get the volunteer's skills
    public function getSkills() {
        return $this->skills;
    }

    // Fetch available events through the AssignEventVolunteerController
    public function fetchAvailableEvents() {
        return $this->assignEventController->getAvailableEvents();
    }

    // Apply for a specific event
    public function applyForEvent($eventId) {
        return $this->assignEventController->assignVolunteer($this->getId(), $eventId);
    }
}