<?php

require_once 'TravelPlanTemplate.php';

class VolunteerTravel extends TravelPlanTemplate {
    protected function validatePlan($details) {
        if (empty($details['volunteers']) || empty($details['destination'])) {
            throw new Exception("Validation failed: Volunteers or destination is missing.");
        }
        echo "Validated volunteer travel plan for " . $details['destination'] . ".\n";
    }

    protected function allocateMeans($details) {
        echo "Assigning " . count($details['volunteers']) . " volunteers to travel.\n";
    }

    protected function executeTravel($details) {
        echo "Notifying volunteers about their travel to " . $details['destination'] . ".\n";
    }
}
?>
