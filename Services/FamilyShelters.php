<?php 

class FamilyShelters implements IService {
    private $numberOfShelters;
    private $shelterLocation;
    private $capacity;
    private $facilities;

    public function __construct($numberOfShelters, $shelterLocation, $capacity, $facilities) {
        $this->numberOfShelters = $numberOfShelters;
        $this->shelterLocation = $shelterLocation;
        $this->capacity = $capacity;
        $this->facilities = $facilities;
    }

    // Implements IService method
    public function setEvent($eventId) {
        // Logic to associate the shelter service with an event
        $query = "INSERT INTO FamilyShelterEvent (eventId, numberOfShelters, shelterLocation, capacity, facilities) 
                  VALUES ('$eventId', '$this->numberOfShelters', '$this->shelterLocation', '$this->capacity', '$this->facilities')";
        return Database::run_query($query);
    }

    // Additional methods specific to FamilyShelters
    public function setCapacity($capacity) {
        $this->capacity = $capacity;
        return true;
    }

    public function addFacilities($facility) {
        $this->facilities .= ", $facility";
        return true;
    }
}
