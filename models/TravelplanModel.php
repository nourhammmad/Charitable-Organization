<?php

$server = $_SERVER['DOCUMENT_ROOT'];
require_once $server . "\Database.php";

class TravelPlanModel {
    private const ALLOWED_TYPES = ['resource_delivery', 'beneficiary_travel'];

    // Create a new travel plan with dynamic attributes
    public static function createTravelPlan($type, $destination, $attributes) {
        if (!in_array($type, self::ALLOWED_TYPES, true)) {
            throw new InvalidArgumentException("Invalid travel plan type. Allowed values are: " . implode(", ", self::ALLOWED_TYPES));
        }

        $attributesJson = json_encode($attributes);

        $query = "INSERT INTO travel_plans (type, destination, attributes) 
                  VALUES ('$type', '$destination', '$attributesJson')";

        return Database::run_query($query); 
    }
     // Fetch a specific travel plan by ID
     public static function getTravelPlanById($id) {
        $query = "SELECT * FROM travel_plans WHERE id = $id";
        $result = Database::run_select_query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Decode the attributes JSON into an array
            $row['attributes'] = json_decode($row['attributes'], true);
            return $row;
        }
        return null;
    }


    // Fetch all travel plans
    public static function getAllTravelPlans() {
        $query = "SELECT * FROM travel_plans";
        $result = Database::run_select_query($query);

        if ($result && $result->num_rows > 0) {
            $travelPlans = [];
            while ($row = $result->fetch_assoc()) {
                // Decode the attributes JSON into an array
                $row['attributes'] = json_decode($row['attributes'], true);
                $travelPlans[] = $row;
            }
            return $travelPlans;
        }
        return [];
    }

    // Fetch a specific travel plan by ID
    // public static function getTravelPlanById($id) {
    //     $query = "SELECT * FROM travel_plans WHERE id = $id";
    //     $result = Database::run_select_query($query);

    //     if ($result && $result->num_rows > 0) {
    //         $row = $result->fetch_assoc();
    //         // Decode the attributes JSON into an array
    //         $row['attributes'] = json_decode($row['attributes'], true);
    //         return $row;
    //     }
    //     return null;
    // }

    // // Delete a travel plan by ID
    // public static function deleteTravelPlanById($id) {
    //     $query = "DELETE FROM travel_plans WHERE id = $id";
    //     return Database::run_query($query);
    // }
}
?>
