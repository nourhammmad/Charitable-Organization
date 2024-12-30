<?php

require_once 'TravelPlanTemplate.php';

class ResourceDeliveryTravel extends TravelPlanTemplate {
    // Validate the plan details
    protected function validatePlan($details) {
        // Check if "resources" and "vehicles" are present
        if (empty($details['resources']) || empty($details['vehicles'])) {
            throw new Exception("Validation failed: resources or vehicles are missing.");
        }
        
        echo "Validated resource delivery plan for " . $details['destination'] . ".\n";
    }

    // Allocate resources to vehicles
    protected function allocateMeans($details) {
        $resourcesCount = count($details['resources']);
        $vehiclesCount = count($details['vehicles']);

        if ($resourcesCount > $vehiclesCount) {
            echo "Warning: Not enough vehicles for all resources. Excess resources will be queued.\n";
        }

        echo "Allocating $resourcesCount resources to $vehiclesCount vehicles.\n";
    }

    // Execute the delivery
    protected function executeTravel($details) {
        $resourcesCount = count($details['resources']);
        $vehiclesCount = count($details['vehicles']);

        echo "Dispatching $vehiclesCount vehicles to deliver $resourcesCount resources to " . $details['destination'] . ".\n";
    }
}
