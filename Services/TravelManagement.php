<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "\controllers\TravelPlanController.php";
require_once 'ResourceDeliveryTravel.php';

class TravelManagement {
    private $travelController;

    public function __construct() {
        $this->travelController = new TravelPlanController();
    }

    // Create a travel plan via the TravelPlanController and instantiate the specific travel plan class
    public function createTravelPlan($type, $destination, $attributes) {
        try {
            // Delegate plan creation to the controller
            $this->travelController->createPlan($type, $destination, $attributes);

            // Instantiate the appropriate travel plan type based on $type
            $travelPlanInstance = $this->instantiateTravelPlan($type);

            if ($travelPlanInstance) {
                echo "Successfully created a travel plan of type: $type.\n";
                return $travelPlanInstance;
            } else {
                throw new Exception("Failed to instantiate the travel plan type: $type.");
            }
        } catch (Exception $e) {
            echo "Error while creating travel plan: " . $e->getMessage();
        }
    }

    // Instantiate a specific travel plan class based on the type
    private function instantiateTravelPlan($type) {
        switch ($type) {
            case 'resource_delivery':
                return new ResourceDeliveryTravel();
            // Add more cases as new types are introduced
            default:
                throw new Exception("Unknown travel plan type: $type.");
        }
    }

    // Execute a travel plan by fetching it from the database
    public function executeTravelPlan($planId) {
        try {
            // Fetch the plan details from the database
            $plan = $this->travelController->getTravelPlanById($planId);

            if (!$plan) {
                throw new Exception("Travel plan with ID $planId not found.");
            }

            // Decode attributes and determine the travel type
            $details = [
                'destination' => $plan['destination'],
                'attributes' => $plan['attributes']
            ];

            $travelPlanInstance = $this->instantiateTravelPlan($plan['type']);

            // Execute the travel plan
            echo "Executing travel plan (ID: $planId)...\n";
            $travelPlanInstance->executeTravelPlan($details);
        } catch (Exception $e) {
            echo "Error while executing travel plan: " . $e->getMessage();
        }
    }
}
?>
