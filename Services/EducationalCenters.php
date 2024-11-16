<?php
require_once "ISer";
class EducationalCenters implements IService {
    private $targetGroup;
    private $numberOfCenters;
    private $centerLocation;

    public function __construct($targetGroup, $numberOfCenters, $centerLocation) {
        $this->targetGroup = $targetGroup;
        $this->numberOfCenters = $numberOfCenters;
        $this->centerLocation = $centerLocation;
    }

    // Implements IService method
    public function setEvent($eventId) {
        // Logic to associate the educational center service with an event
        $query = "INSERT INTO EducationalCenterEvent (eventId, targetGroup, numberOfCenters, centerLocation) 
                  VALUES ('$eventId', '$this->targetGroup', '$this->numberOfCenters', '$this->centerLocation')";
        return Database::run_query($query);
    }

    // Additional methods specific to EducationalCenters
    public function addInstructor() {
        // Logic to add an instructor (for now, return true as a placeholder)
        return true;
    }
}
