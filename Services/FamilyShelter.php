<?php
// $server=$_SERVER['DOCUMENT_ROOT'];

require_once "D:/SDP/project/Charitable-Organization/Services/IServices.php";

class FamilyShelter implements IServices {
    // Attributes
    private $quantity;
    private $NoShelters;
    private $familyShelterLocation;
    private $accessLevel; // Default is 0

    // Constructor to initialize attributes
    public function __construct($quantity, $NoShelters, $familyShelterLocation) {
        $this->quantity = $quantity;
        $this->NoShelters = $NoShelters;
        $this->familyShelterLocation = $familyShelterLocation;
        $this->accessLevel = 0; // Default value
    }

    // Getter for food quantity
    public function familyShelterLocation() {
        return $this->familyShelterLocation;
    }

    // Getter for food type
    public function NoShelters() {
        return $this->NoShelters;
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
?>
