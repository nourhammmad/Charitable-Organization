<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "\controllers\TravelPlanController.php";
require_once $_SERVER['DOCUMENT_ROOT'] ."\Services\ResourcesDeliveryTravel.php";
require_once $_SERVER['DOCUMENT_ROOT'] ."\Services\BeneficiaryTravel.php";
require_once $_SERVER['DOCUMENT_ROOT'] ."\models\BeneficiaryModel.php";

class TravelManagement {
    private $travelController;

    public function __construct() {
        $this->travelController = new TravelPlanController();
    }

    // Create a travel plan via the TravelPlanController and instantiate the specific travel plan class
    public  function createTravelPlan($type, $destination, $attributes) {
        try {

            if($type == 'beneficiary_travel'){
                $destination = Beneficiary::getBeneficiaryAddressID($destination);
            }
            $this->travelController->createPlan($type, $destination, $attributes);

            echo "Successfully created a travel plan of type: $type.\n";
               
        } catch (Exception $e) {
            echo "Error while creating travel plan: " . $e->getMessage();
        }
    }

    // Instantiate a specific travel plan class based on the type
    private function instantiateTravelPlan($type) {
        switch ($type) {
            case 'resource_delivery':
                return new ResourceDeliveryTravel();
 
            case 'beneficiary_travel':
                return new BeneficiaryTravel();
                
            default:
                throw new Exception("Unknown travel plan type: $type.");
        }
    }

   
    public function executeTravelPlan($planId) {
        try {
            // Fetch the plan details from the database
            $plan = $this->travelController->getTravelPlanById($planId);
            print($plan['destination']);
            if (!$plan) {
                throw new Exception("Travel plan with ID $planId not found.");
            }
    
            // Decode attributes
            $attributes = is_array($plan['attributes']) ? $plan['attributes'] : json_decode($plan['attributes'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Failed to parse attributes JSON for plan ID: $planId");
            }

            // Build the details array
            $details = [
                'destination' => $plan['destination'],
                'attributes' => $attributes // Pass raw attributes to the template
            ];

            switch ($plan['type']) {
            case 'resource_delivery':
                // ($details['resources']);
                $details['resources'] = $attributes['resources'] ?? [];
                $details['numOfVechile'] = $attributes['numOfVechile'] ?? [];
                $details['typeOfTruck'] = $attributes['typeOfTruck'] ?? [];
                break;

            case 'beneficiary_travel':
                
                $details['numOfVechile'] = $attributes['numOfVechile'] ?? [];
                $details['typeOfTruck'] = $attributes['typeOfTruck'] ?? [];
                break;

            default:
                throw new Exception("Unknown travel plan type: {$plan['type']}");
        }
            $travelPlanInstance = $this->instantiateTravelPlan($plan['type']);
    
            echo "Executing travel plan (ID: $planId)...\n";
            $travelPlanInstance->executeTravelPlan($details);
        } catch (Exception $e) {
            echo "Error while executing travel plan: " . $e->getMessage();
        }
    }
    
}
?>
