<?php
require_once $_SERVER['DOCUMENT_ROOT']."./Services/FamilyShelter.php"; // Include the FamilyShelter class
require_once $_SERVER['DOCUMENT_ROOT']."./Services/AccessabilityDecorator.php"; // Include the Accessibility Decorator
require_once $_SERVER['DOCUMENT_ROOT']."./Services/SignLangInterpret.php"; // Include the SignLangInterpret decorator
require_once $_SERVER['DOCUMENT_ROOT']."./Services/Wheelchair.php"; // Include the Wheelchair decorator
require_once $_SERVER['DOCUMENT_ROOT']."./models/EventModel.php"; // Include the EventModel class

class FamilyShelterController {

    public static function createFamilyShelterEvent($eventName, $date, $EventAttendanceCapacity, $tickets, $signLangInterpret, $wheelchair) {
        $eventName="Family Shelter";
        $capacity=23;

        // Step 1: Create the base FamilyShelter instance
        $familyShelterService = new FamilyShelter($EventAttendanceCapacity, $capacity, 'Shelter Location'); // Example values for family shelter

        // Step 2: Apply decorators based on accessibility features
        if ($signLangInterpret) {
            $familyShelterService = new SignLangInterpret($familyShelterService);
        }
        if ($wheelchair) {
            $familyShelterService = new Wheelchair($familyShelterService);
        }

        // Step 3: Get the final access level after decorators are applied
        $finalAccessLvl = $familyShelterService->showAccessLevel();
        $numberOfShelters=12;
        $shelterLocation="adsjnk";
        // Step 4: Create the event in the EventModel
        $isEventCreated = EventModel::CreateFamilyShelterEvent($eventName, $date,$capacity, $tickets, $numberOfShelters,$shelterLocation,$EventAttendanceCapacity ,$finalAccessLvl);
        
        return $isEventCreated;
    }
}

?>
