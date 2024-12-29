<?php

$server = $_SERVER['DOCUMENT_ROOT'];
require_once $server . "\models\TravelPlanModel.php";

class TravelPlanController {
    // Create a travel plan
    public function createPlan($type, $destination, $attributes) {
        try {
            $result = TravelPlanModel::createTravelPlan($type, $destination, $attributes);

            if ($result) {
                echo "Travel plan created successfully for destination: $destination.\n";
            } else {
                echo "Failed to create travel plan. Please try again.\n";
            }
        } catch (InvalidArgumentException $e) {
            echo "Error: " . $e->getMessage();
        } catch (Exception $e) {
            echo "An unexpected error occurred: " . $e->getMessage();
        }
    }
    public function getAllPlans() {
        try {
            // Call the model to fetch all travel plans
            $travelPlans = TravelPlanModel::getAllTravelPlans();

            if (!empty($travelPlans)) {
                return $travelPlans;
            } else {
                echo "No travel plans found.\n";
                return [];
            }
        } catch (Exception $e) {
            echo "An unexpected error occurred while fetching travel plans: " . $e->getMessage();
            return [];
        }
    }
    // Fetch a travel plan by ID
    public function getTravelPlanById($id) {
        try {
            return TravelPlanModel::getTravelPlanById($id);
        } catch (Exception $e) {
            echo "Error fetching travel plan: " . $e->getMessage();
            return null;
        }
    }
}
?>
