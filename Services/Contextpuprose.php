<?php

require_once ('./Services/IPurpose.php');
// Implementing the FoodBank class
class FoodBank implements IPurpose {
    private int $foodQuantity;
    private string $foodType;
    private string $foodBankLocation;

    public function __construct($foodQuantity, $foodType, $foodBankLocation) {
        $this->foodQuantity = $foodQuantity;
        $this->foodType = $foodType;
        $this->foodBankLocation = $foodBankLocation;
    }

    public function setEvent(): void {
        echo "Setting up a FoodBank event with $this->foodQuantity items of $this->foodType at $this->foodBankLocation.<br>";
    }

    public function setFoodType(string $type): void {
        $this->foodType = $type;
    }
}

// Implementing the FamilyShelters class
class FamilyShelters implements IPurpose {
    private int $numberOfShelters;
    private string $shelterLocation;
    private int $capacity;
    private string $facilities;

    public function __construct($numberOfShelters, $shelterLocation, $capacity, $facilities) {
        $this->numberOfShelters = $numberOfShelters;
        $this->shelterLocation = $shelterLocation;
        $this->capacity = $capacity;
        $this->facilities = $facilities;
    }

    public function setEvent(): void {
        echo "Setting up a Family Shelter event at $this->shelterLocation with capacity $this->capacity.<br>";
    }

    public function setCapacity(int $capacity): void {
        $this->capacity = $capacity;
    }

    public function addFacilities(string $facility): bool {
        $this->facilities .= ", $facility";
        return true;
    }
}

// Implementing the EducationalCenters class
class EducationalCenters implements IPurpose {
    private string $targetGroup;
    private int $numberOfCenters;
    private string $centerLocation;

    public function __construct($targetGroup, $numberOfCenters, $centerLocation) {
        $this->targetGroup = $targetGroup;
        $this->numberOfCenters = $numberOfCenters;
        $this->centerLocation = $centerLocation;
    }

    public function setEvent(): void {
        echo "Setting up an Educational Center event for $this->targetGroup at $this->centerLocation.<br>";
    }

    public function addInstructor(): bool {
        // Logic to add an instructor
        return true;
    }
}

// ContextPurpose class that uses the IPurpose interface
class ContextPurpose {
    private IPurpose $purpose;

    public function __construct(IPurpose $purpose) {
        $this->purpose = $purpose;
    }

    public function setPurpose(IPurpose $purpose): void {
        $this->purpose = $purpose;
    }

    public function executeEvent(): void {
        $this->purpose->setEvent();
    }
}

// Example Usage
$foodBank = new FoodBank(100, "Canned Goods", "Downtown Location");
$familyShelter = new FamilyShelters(5, "Shelter Avenue", 200, "Medical, Food");
$educationalCenter = new EducationalCenters("Teens", 3, "Main Library");

// Using ContextPurpose
$context = new ContextPurpose($foodBank);
$context->executeEvent();

$context->setPurpose($familyShelter);
$context->executeEvent();

$context->setPurpose($educationalCenter);
$context->executeEvent();

?>