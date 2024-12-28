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
