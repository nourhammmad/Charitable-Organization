<?php

require_once 'TravelPlanTemplate.php';

class ResourceDeliveryTravel extends TravelPlanTemplate {
    protected function validatePlan($details) {
        if (empty($details['means']) || empty($details['vehicles'])) {
            throw new Exception("Validation failed: means or vehicles are missing.");
        }
        echo "Validated resource delivery plan for " . $details['destination'] . ".\n";
    }

    protected function allocateMeans($details) {
        echo "Allocating " . count($details['means']) . " means to " . count($details['vehicles']) . " vehicles.\n";
    }

    protected function executeTravel($details) {
        echo "Dispatching vehicles to deliver means to " . $details['destination'] . ".\n";
    }
}
?>
