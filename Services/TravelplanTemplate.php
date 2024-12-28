<?php

abstract class TravelPlanTemplate {
    // Template method: defines the workflow
    public final function executeTravelPlan($details) {
        $this->validatePlan($details);       // Step 1: Validate the plan
        $this->allocateMeans($details); // Step 2: Allocate resources
        $this->executeTravel($details);     // Step 3: Execute the travel
        $this->logCompletion($details);     // Step 4: Log the completion
    }

    // Abstract methods to be implemented by subclasses
    protected abstract function validatePlan($details);
    protected abstract function allocateMeans($details);
    protected abstract function executeTravel($details);

    // Common step: Log the completion of the travel plan
    protected function logCompletion($details) {
        echo "Travel plan for " . $details['destination'] . " completed.\n";
    }
}
?>
