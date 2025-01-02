<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'./models/VolunteerModel.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'./models/VolunteerTaskAssignmentModel.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'./controllers/VolunteerEventAssignmentController.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'./models/EventModel.php';

class VolunteerEventHandlerController {
    private $volunteerModel;
    private $assignEventController;
    private $assignTaskController;

    public function __construct($volunteerId) {
        $this->volunteerModel = VolunteerModel::getVolunteerById($volunteerId);
        $this->assignEventController = new VolunteerEventAssignmentController();
        $this->assignTaskController=new VolunteerTaskAssignmentController();
    }


    public function applyForEvent($eventId) {
        if ($this->volunteerModel) {
            // Check if already assigned to the event
            $isAlreadyAssigned = VolunteerModel::isVolunteerAssignedToEvent($this->volunteerModel->getId(), $eventId);
            if ($isAlreadyAssigned) {
                return "You have already applied to this event.";
            }
    
            // Proceed with assignment
            $result = $this->assignEventController->assignVolunteer((int)$this->volunteerModel->getId(), $eventId);
    
            if ($result) {
                // Fetch event details by event ID
                $eventData = EventModel::getEventById($eventId);
                if ($eventData) {
                    // Create an EventSubject instance with the required 8 arguments
                    $event = new EventModel(
                        $eventData['eventId'], 
                        $eventData['eventName'], 
                        $eventData['date'], 
                        $eventData['addressId'], 
                        $eventData['EventAttendanceCapacity'], 
                        $eventData['tickets'], 
                        $eventData['created_at'], 
                        $eventData['event_type_id']
                    );
                  
                    $event->addObserver($this->volunteerModel);
                    // echo "Current Observers for Event ID " . $eventId . ":<br>";
                    // $event->listObservers();
    
                    return "Successfully applied to the event and registered as an observer.";
                } else {
                    return "Failed to retrieve event details.";
                }
            } else {
                return "Failed to apply to the event.";
            }
        } else {
            return "Volunteer not found.";
        }
    }   
        public function applyForTask($taskId) {
            if ($this->volunteerModel) {
                $result = $this->assignTaskController->assignTaskToUser((int)$this->volunteerModel->getId(), $taskId);
                return $result ? "Successfully applied to the task." : "Failed to apply to the task.";
            } else {
                return "Task not found.";
            }
        }
    }
    
    // Handle the POST request for applying to an event
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $volunteerId = isset($_POST['volunteerId']) ? $_POST['volunteerId'] : null;
        $eventId = isset($_POST['eventId']) ? $_POST['eventId'] : null;
        $taskId = isset($_POST['taskId']) ? $_POST['taskId'] : null;
     
    
        // Debugging: Log the received data
        error_log("Volunteer ID: " . $volunteerId);
        error_log("Event ID: " . $eventId);
    
        if ($volunteerId && $eventId) {
            $handler = new VolunteerEventHandlerController($volunteerId);
            echo $handler->applyForEvent($eventId);
        } else {
            $handler = new VolunteerTaskAssignmentController($volunteerId);
            
            echo $handler->assignTaskToUser($taskId,$volunteerId);
        }
    }else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $volunteerId = isset($_GET['volunteer_id']) ? $_GET['volunteer_id'] : null;
        $action = isset($_GET['action']) ? $_GET['action'] : null;
    
        // Debugging: Log the received data
        error_log("Volunteer ID: " . $volunteerId);
        error_log("Action: " . $action);
    
        if ($volunteerId) {
            $handler = new VolunteerController($volunteerId);
    
            if ($action === 'getEvents') {
                $events = $handler->displayAvailableEvents();
                if (empty($events)) {
                    echo json_encode(['message' => 'No events available.']);
                } else {
                    // Check if volunteer is assigned to each event
                    foreach ($events as &$event) {
                        // Check if the volunteer is assigned to this event
                        $isApplied = VolunteerModel::isVolunteerAssignedToEvent($volunteerId, $event['eventId']);
                        $event['isApplied'] = $isApplied;  // Add the isApplied status to each event
                    }
                    echo json_encode(['events' => $events]);
                }
            } elseif ($action === 'getTasks') {
                $tasks = $handler->displayAllTasks();
                error_log("Fetched tasks: " . print_r($tasks, true));
    
                if (empty($tasks)) {
                    echo json_encode(['message' => 'No tasks available.']);
                } else {
                    foreach ($tasks as &$task) {
                        // Check if the volunteer is assigned to this event
                        $isApplied = VolunteerTaskAssignmentModel::isVolunteerAssignedToTask($volunteerId, $task['id']);
                        $task['isApplied'] = $isApplied;  // Add the isApplied status to each event
                    }
                    echo json_encode(['tasks' => $tasks]);
    
                }
            } else {
                echo json_encode(['message' => 'Invalid action.']);
            }
        } else {
            echo json_encode(['message' => 'Volunteer ID is required.']);
        }
    }
    
    ?>