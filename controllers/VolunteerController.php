<?php
$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server."\Services\Volunteer.php";
require_once $server."\controllers\VolunteerEventAssignmentController.php";
require_once $server."\controllers\VolunteerTaskAssignmentController.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\CommandHandler.php";

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
    
    public static function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? null;
            $userId = $_POST['userId'] ?? null;
  
            // Collect donation data if donationType is provided

        
            // Ensure action and donorId are provided
            if ($action && $userId) {
                CommandHandler::handleRequest($action, $userId, null, null, null);
            } else {
                echo json_encode(['success' => false, 'message' => 'Action or donorId is missing.']);
            }
        }
        
    }
    
    public function getVolunteerNotifications($volunteerId) {
        header('Content-Type: application/json'); // Set header for JSON response
        error_log("v id: $volunteerId");
        // Get notifications by volunteer ID
        $notifications = VolunteerModel::getNotificationsByVolunteerId($volunteerId);
    
        if (!empty($notifications)) {
            // Extract only the 'message' column
            $messages = array_column($notifications, 'message');

            // Return success response in JSON format
            echo json_encode([
                'success' => true,
                'notifications' => $messages
            ]);
        } else {
            // Return failure response
            echo json_encode([
                'success' => false,
                'message' => 'No notifications found.'
            ]);
        }
    }
    

}
 