<?php

require_once 'TravelPlanTemplate.php';

class ResourceDeliveryTravel extends TravelPlanTemplate {
    protected function validatePlan($details) {
        if (empty($details['means']) || empty($details['vehicles'])) {
            throw new Exception("Validation failed here in resources: means or vehicles are missing.");
        }
        echo "Validated resource delivery plan for " . $details['destination'] . ".\n";
    }
    

    protected function allocateMeans($plan) {
        $meansCount = count($plan['means']);
        $vehiclesCount = count($plan['vehicles']);

        if ($meansCount > $vehiclesCount) {
            echo "Warning: Not enough vehicles for all means. Excess means will be queued.\n";
        }

        echo "Allocating $meansCount means to $vehiclesCount vehicles.\n";
    }

    protected function executeTravel($plan) {
        $vehiclesCount = count($plan['vehicles']);
        $meansCount = count($plan['means']);

        echo "Dispatching $vehiclesCount vehicles to deliver $meansCount means to " . $plan['destination'] . ".\n";
    }
}
?>
