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

    // public static function getAllTravelPlans() {
    //     $query = "SELECT * FROM travel_plans";
    //     $result = Database::run_select_query($query);
    
    //     if ($result && $result->num_rows > 0) {
    //         $travelPlans = [];
    //         while ($row = $result->fetch_assoc()) {
    //             // Check if the attributes column contains valid JSON
    //             if (isset($row['attributes']) && is_string($row['attributes'])) {
    //                 $decodedAttributes = json_decode($row['attributes'], true);
                    
    //                 // Handle JSON decoding errors
    //                 if (json_last_error() === JSON_ERROR_NONE) {
    //                     $row['attributes'] = $decodedAttributes; // Valid JSON, assign decoded array
    //                 } else {
    //                     $row['attributes'] = []; // Default to an empty array if JSON is invalid
    //                     error_log("Invalid JSON in travel plan attributes (ID: {$row['id']}): " . $row['attributes']);
    //                 }
    //             } else {
    //                 $row['attributes'] = []; // Default to empty array if attributes is not set or not a string
    //             }
    
    //             $travelPlans[] = $row;
    //         }
    //         return $travelPlans;
    //     }
    
    //     return [];
    // }
    

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
    // public static function getAllTravelPlans() {
    //     $query = "SELECT * FROM travel_plans";
    //     $result = Database::run_select_query($query);
    
    //     if ($result && $result->num_rows > 0) {
    //         $travelPlans = [];
    //         while ($row = $result->fetch_assoc()) {
    //             // Debugging: Inspect the raw attributes JSON
    //             error_log("Debugging - Raw Attributes JSON: " . $row['attributes']);
    
    //             // Decode the attributes JSON into an array
    //             $attributes = json_decode($row['attributes'], true);
    
    //             // Check for JSON decoding errors
    //             if (json_last_error() !== JSON_ERROR_NONE) {
    //                 error_log("Warning: Failed to decode JSON for travel plan ID {$row['id']}. Error: " . json_last_error_msg());
    //                 $attributes = []; // Use an empty array as a fallback
    //             }
    
    //             // Debugging: Inspect the decoded attributes
    //             error_log("Debugging - Decoded Attributes: " . print_r($attributes, true));
    
    //             // Add the decoded attributes to the row
    //             $row['attributes'] = $attributes;
    //             $travelPlans[] = $row;
    //         }
    //         return $travelPlans;
    //     }
    //     return [];
    // }

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
