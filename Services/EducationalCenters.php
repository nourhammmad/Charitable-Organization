<?php
$server=$_SERVER['DOCUMENT_ROOT'];

require_once $server."\Services\IServices.php";
class EducationalCenters implements IServices {
    private $quantity;
    private $NoCenters;
    private $EducationalCenterLocation;
    private $accessLevel; 

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

