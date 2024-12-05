<?php


require_once  $_SERVER['DOCUMENT_ROOT']."\Services\IServices.php";
class FoodBank implements IServices {
    // Attributes
    private $foodQuantity;
    private $foodType;
    private $foodBankLocation;
    private $accessLevel; // Default is 0

    // Constructor to initialize attributes
    public function __construct($foodQuantity, $foodType, $foodBankLocation) {
        $this->foodQuantity = $foodQuantity;
        $this->foodType = $foodType;
        $this->foodBankLocation = $foodBankLocation;
        $this->accessLevel = 0; // Default value
    }

    // Getter for food quantity
    public function getFoodQuantity() {
        return $this->foodQuantity;
    }

    // Getter for food type
    public function getFoodType() {
        return $this->foodType;
    }

    // Getter for food bank location
    public function getFoodBankLocation() {
        return $this->foodBankLocation;
    }

    // Getter for access level
    public function showAccessLevel(): int
    {
        return $this->accessLevel;    
    }

}
?>
