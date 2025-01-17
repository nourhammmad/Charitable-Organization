<?php

require_once 'TravelPlanTemplate.php';

class ResourceDeliveryTravel extends TravelPlanTemplate {
    protected function validatePlan($details) {
        if (empty($details['numOfVechile']) || empty($details['typeOfTruck'])|| empty($details['resources'])) {
            throw new Exception("Validation failed: numOfVechile or typeOfTruck are missing.");
        }
        
        echo "Validated resource delivery plan for " . $details['destination'] . ".\n";
    }

    // Allocate numOfVechile to typeOfTruck
    protected function allocateMeans($details) {
        $numOfVechile = intval($details['numOfVechile']); 
        $typeOfTruck = $details['typeOfTruck']; 
        $resources = $details['resources']; 
    
        // Check if there are vehicles and resources
        if ($numOfVechile <= 0) {
            echo "No vehicles available.\n";
            return;
        }
    
        if (empty($resources)) {
            echo "No resources available.\n";
            return;
        }
    
        echo "Allocating $numOfVechile vehicles of type '$typeOfTruck'.\n";
        echo "Distributing " . count($resources) . " resources.\n";
    
        // Assign resources to vehicles
        $resourceIndex = 0;
        for ($i = 1; $i <= $numOfVechile; $i++) {
            // Stop the loop if all resources have been allocated
            if ($resourceIndex >= count($resources)) {
                break;
            }
    
            echo "Vehicle $i ($typeOfTruck) is carrying: ";
    
            // Assign one resource to the vehicle
            if ($resourceIndex < count($resources)) {
                echo "resouces of id: " . $resources[$resourceIndex] . " "; // Output the resource ID
                $resourceIndex++; // Move to the next resource
            }
    
            echo "\n";
        }
    
        // Handle remaining resources
        if ($resourceIndex < count($resources)) {
            $remaining = count($resources) - $resourceIndex;
            echo "Warning: $remaining resources could not be allocated.\n";
        }
    }

   
}
