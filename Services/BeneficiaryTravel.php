<?php 

require_once 'TravelPlanTemplate.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/BeneficiaryModel.php";

class BeneficiaryTravel extends TravelPlanTemplate {

    // Validate the plan details
    protected function validatePlan($details) {
        // Check if "numOfVechile" and "typeOfTruck" are present
        if (empty($details['numOfVechile']) || empty($details['typeOfTruck'])) {
            throw new Exception("Validation failed: numOfVechile or typeOfTruck are missing.");
        }
        
        echo "Validated resource delivery plan for " . $details['destination'] . ".\n";
    }

    // Allocate numOfVechile to typeOfTruck
    protected function allocateMeans($details) {
        $numOfVechileCount = $details['numOfVechile'];
        $typeOfTruckCount = $details['typeOfTruck'];
    
        // Convert numOfVechile to an integer for comparison
        $numOfVechile = intval($numOfVechileCount);
    
        // Check if numOfVechile is greater than 0
        if ($numOfVechile > 0) {
            echo "Allocating $numOfVechileCount vehicles to $typeOfTruckCount trucks.\n";
        } else {
            echo "No vehicles to allocate. numOfVechile must be greater than 0.\n";
        }
    }
    // Execute the delivery
   
}
