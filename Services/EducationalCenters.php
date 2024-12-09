<?php
require_once "Services\IServices.php";
class EducationalCenters implements IServices {
    private $quantity;
    private $NoCenters;
    private $EducationalCenterLocation;
    private $accessLevel; // Default is 0

    // Constructor to initialize attributes
    public function __construct($quantity, $NoCenters, $EducationalCenterLocation) {
        $this->quantity = $quantity;
        $this->NoCenters = $NoCenters;
        $this->EducationalCenterLocation = $EducationalCenterLocation;
        $this->accessLevel = 0; // Default value
    }

    // Getter for food quantity
    public function EducationalCenterLocation() {
        return $this->EducationalCenterLocation;
    }

    // Getter for food type
    public function NoCenters() {
        return $this->NoCenters;
    }

    // Getter for food bank location
    public function quantity() {
        return $this->quantity;
    }

    // Getter for access level
    public function showAccessLevel():int{
        return $this->accessLevel;
    }

}
//     private $targetGroup;
//     private $numberOfCenters;
//     private $centerLocation;

//     public function __construct($targetGroup, $numberOfCenters, $centerLocation) {
//         $this->targetGroup = $targetGroup;
//         $this->numberOfCenters = $numberOfCenters;
//         $this->centerLocation = $centerLocation;
//     }

//     // Implements IService method
//     public function setEvent($eventId) {
//         // Logic to associate the educational center service with an event
//         $query = "INSERT INTO EducationalCenterEvent (eventId, targetGroup, numberOfCenters, centerLocation) 
//                   VALUES ('$eventId', '$this->targetGroup', '$this->numberOfCenters', '$this->centerLocation')";
//         return Database::run_query($query);
//     }

//     // Additional methods specific to EducationalCenters
//     public function addInstructor() {
//         // Logic to add an instructor (for now, return true as a placeholder)
//         return true;
//     }
// }
