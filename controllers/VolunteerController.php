<?php
$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server."\Services\Volunteer.php";
require_once $server."\controllers\VolunteerEventAssignmentController.php";
require_once $server."\controllers\VolunteerTaskAssignmentController.php";
 
class VolunteerController {
    private $volunteerModel;
    private $assignEventController;
    private $assignTaskController;

    // Initialize with a VolunteerModel instance and create an assignment controller instance
    public function __construct($volunteerId) {
        $this->volunteerModel = VolunteerModel::getVolunteerById($volunteerId);
        $this->assignEventController = new VolunteerEventAssignmentController();
        $this->assignTaskController = new VolunteerTaskAssignmentController();
    }
    public function getAssignEventController() {
        return $this->assignEventController;
    }

    public function displayAvailableEvents() {
        return $this->assignEventController->getAvailableEvents() ?: [];
    }
    public function displayAllTasks() {
        return $this->assignTaskController->viewAllTasks() ?: [];
    }
    
    public function applyForEvent($eventId) {
        if ($this->volunteerModel) {
            $result = $this->assignEventController->assignVolunteer((int)$this->volunteerModel->getId(), $eventId);
            echo $result;  // Send the result back (e.g., success or failure message)
        } else {
            echo "Volunteer not found.";  // Send an error if volunteer doesn't exist
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
   
    
    public function getVolunteerNotifications($volunteerId) {
        $notifications=Volunteer::getNotificationsByVolunteerId($volunteerId);
        if (!empty($notifications)) {
            echo json_encode([
                'success' => true,
                'notifications' => $notifications
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No notifications found.'
            ]);
        }
    }

}
 