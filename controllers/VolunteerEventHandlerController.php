<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './models/VolunteerModel.php';
require_once $_SERVER['DOCUMENT_ROOT'] . './controllers/VolunteeEventAssignmentController.php';

class VolunteerEventHandlerController {
    private $volunteerModel;
    private $assignEventController;

    public function __construct($volunteerId) {
        $this->volunteerModel = VolunteerModel::getVolunteerById($volunteerId);
        $this->assignEventController = new VolunteeEventAssignmentController();
    }

    public function applyForEvent($eventId) {
        if ($this->volunteerModel) {
            $result = $this->assignEventController->assignVolunteer((int)$this->volunteerModel->getId(), $eventId);
            return $result ? "Successfully applied to the event." : "Failed to apply to the event.";
        } else {
            return "Volunteer not found.";
        }
    }
}

// Handle the POST request for applying to an event
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $volunteerId = isset($_POST['volunteerId']) ? $_POST['volunteerId'] : null;
    $eventId = isset($_POST['eventId']) ? $_POST['eventId'] : null;

    // Debugging: Log the received data
    error_log("Volunteer ID: " . $volunteerId);
    error_log("Event ID: " . $eventId);

    if ($volunteerId && $eventId) {
        $handler = new VolunteerEventHandlerController($volunteerId);
        echo $handler->applyForEvent($eventId);
    } else {
        echo "Missing volunteer or event ID.";}
}
?>