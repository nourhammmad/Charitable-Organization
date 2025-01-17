<?php

abstract class TravelPlanTemplate {
    // Template method: defines the workflow
    public final function executeTravelPlan($details) {
        $this->validatePlan($details);       // Step 1: Validate the plan
        $this->allocateMeans($details);     // Step 2: Allocate resources
        $this->executeTravel($details);     // Step 3: Execute the travel
        $this->logCompletion($details);     // Step 4: Log the completion
    }

    // Abstract methods to be implemented by subclasses
    protected abstract function validatePlan($details);
    protected abstract function allocateMeans($details);
    protected function executeTravel($details) {
        $numOfVechile = intval($details['numOfVechile']); 
        $typeOfTruck = $details['typeOfTruck']; 
        $destination = $details['destination']; 
    
        // Check if there are vehicles available
        if ($numOfVechile <= 0) {
            echo "No vehicles available for travel.\n";
            return;
        }
    
        echo "Starting travel to $destination using $numOfVechile $typeOfTruck(s).\n";
    
        // Simulate the travel process
        $this->simulateTravelProcess($numOfVechile, $typeOfTruck, $destination);
    
        echo "All $typeOfTruck(s) have successfully reached $destination.\n";
    }
    
    /**
     * Simulates the travel process for the vehicles.
     *
     * @param int $numOfVechile The number of vehicles.
     * @param string $typeOfTruck The type of truck.
     * @param string $destination The destination.
     */
    private function simulateTravelProcess($numOfVechile, $typeOfTruck, $destination) {
        for ($i = 1; $i <= $numOfVechile; $i++) {
            echo "$typeOfTruck $i is on the way to $destination.\n";
    
            // Simulate travel delay
            $this->simulateTravelDelay();
    
            echo "$typeOfTruck $i has arrived at $destination.\n";
        }
    }
  
    private function simulateTravelDelay() {
        sleep(1); 
    }

  

    // Common step: Log the completion of the travel plan
    protected function logCompletion($details) {
        echo "Travel plan for " . $details['destination'] . " completed.\n";
    }
}
?>
