<?php
require_once "./models/VolunteerModel.php";
require_once "./controllers/VolunteeEventAssignmentController.php.php";
require_once "./controllers/VolunteerTaskAssignmentController.php";


class VolunteerCotroller {
    private $volunteerModel;
    private $assignEventController;
    private $assignTaskController ;

    // Initialize with a VolunteerModel instance and create an assignment controller instance
    public function __construct($volunteerId) {
        $this->volunteerModel = VolunteerModel::getVolunteerById($volunteerId);
        $this->assignEventController = new VolunteeEventAssignmentController();
        $this->assignTaskController = new VolunteerTaskAssignmentController();
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
    public function displayAllTasks() {
        // Fetch all tasks using the TaskModel
        $tasks = $this ->assignTaskController->viewAllTasks();  // Call the method from TaskModel
    
        // Check if tasks are available and display them
        if (is_array($tasks) && !empty($tasks)) {
            echo "Available Tasks:<br>";
            foreach ($tasks as $task) {
                // Display task details using array keys
                echo "Task ID: " . $task['id'] . ", Name: " . $task['name'] . ", Required Skill: " . $task['requiredSkill'] . "<br>";
            }
        } else {
            echo "No tasks available at the moment.";
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
    public function applyForTask($taskId) {
        if ($this->volunteerModel) {
            $result = VolunteerTaskAssignmentController::assignTaskToUser($taskId, $this->volunteerModel->getId());
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
