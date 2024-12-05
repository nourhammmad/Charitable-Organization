<?php
$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server."\models\VolunteerModel.php";
require_once $server."\controllers\VolunteeEventAssignmentController.php";
require_once $server."\controllers\VolunteerTaskAssignmentController.php";

// require_once $server."./db-populate.php";

// try {
//     $db =  Database::getInstance();
//     Populate::populate();
// } catch (Exception $e) {
//     echo "Error initializing Database: " . $e->getMessage();
//     exit;
// }


class VolunteerCotroller {
    private $volunteerModel;
    private $assignEventController;
    private $assignTaskController;

    // Initialize with a VolunteerModel instance and create an assignment controller instance
    public function __construct($volunteerId) {
        $this->volunteerModel = VolunteerModel::getVolunteerById($volunteerId);
        $this->assignEventController = new VolunteeEventAssignmentController();
        $this->assignTaskController = new VolunteerTaskAssignmentController();

       
    }
    public function getAssignEventController() {
        return $this->assignEventController;
    }

    public function displayAvailableEvents() {
        // Ensure $this->assignEventController->getAvailableEvents() is returning an array
        $events = $this->assignEventController->getAvailableEvents();
        
        // Check if events are returned and not an error message
        if (is_array($events) && !empty($events)) {
            return $events;
        } else {
            return [];  // Return an empty array if no events found
        }
    }
    public function displayAllTasks() {
        // Fetch all tasks using the TaskModel
        $tasks = $this ->assignTaskController->viewAllTasks();  // Call the method from TaskModel
    
        if (is_array($tasks) && !empty($tasks)) {
            return $tasks;
        } else {
            return [];
}}
    
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
    public function update($event, $message) {
        echo "Notification for Volunteer {$this->volunteerModel->getId()}: {$message}<br>";
}
}
//$volu=new VolunteerCotroller(1);