<?php
require_once "F:/senior 2/Design Patterns/project/Charitable-Organization/Services/FamilyShelter.php"; // Include the FamilyShelter class
require_once "F:/senior 2/Design Patterns/project/Charitable-Organization/Services/AccessabilityDecorator.php"; // Include the Accessibility Decorator
require_once "F:/senior 2/Design Patterns/project/Charitable-Organization/Services/SignLangInterpret.php"; // Include the SignLangInterpret decorator
require_once "F:/senior 2/Design Patterns/project/Charitable-Organization/Services/Wheelchair.php"; // Include the Wheelchair decorator
require_once "F:/senior 2/Design Patterns/project/Charitable-Organization/models/EventModel.php"; // Include the EventModel class

class FamilyShelterController {

    public static function createFamilyShelterEvent($eventName ,$date,$capacity ,$EventAttendanceCapacity, $tickets, $signLangInterpret, $wheelchair) {
       // $eventName="Family Shelter";
       // $capacity=10;

    //Decorator
        $familyShelterService = new FamilyShelter($EventAttendanceCapacity, $capacity, 'Shelter Location'); // Example values for family shelter

        if ($signLangInterpret) {
            $familyShelterService = new SignLangInterpret($familyShelterService);
        }
        if ($wheelchair) {
            $familyShelterService = new Wheelchair($familyShelterService);
        }

        $finalAccessLvl = $familyShelterService->showAccessLevel();
        $numberOfShelters=12;
        $shelterLocation="cairo";

        $isEventCreated = EventModel::CreateFamilyShelterEvent($eventName, $date,$capacity, $tickets, $numberOfShelters,$shelterLocation,$EventAttendanceCapacity ,$finalAccessLvl);
        
        return $isEventCreated;
    }
}

?>
