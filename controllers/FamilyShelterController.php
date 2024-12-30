<?php

require_once $_SERVER['DOCUMENT_ROOT']."\Services\FamilyShelter.php"; // Include the FamilyShelter class
require_once $_SERVER['DOCUMENT_ROOT']."\Services\AccessabilityDecorator.php"; // Include the Accessibility Decorator
require_once $_SERVER['DOCUMENT_ROOT']."\Services\SignLangInterpret.php"; // Include the SignLangInterpret decorator
require_once $_SERVER['DOCUMENT_ROOT']."\Services\Wheelchair.php"; // Include the Wheelchair decorator
require_once $_SERVER['DOCUMENT_ROOT']."\models\EventModel.php"; // Include the EventModel class

class FamilyShelterController {

    public static function createFamilyShelterEvent($eventName ,$date,$capacity ,$EventAttendanceCapacity, $tickets,$shelterLocation ,$signLangInterpret, $wheelchair) {
       
        $familyShelterService = new FamilyShelter($EventAttendanceCapacity, $capacity, $shelterLocation); // Example values for family shelter

        if ($signLangInterpret) {
            $familyShelterService = new SignLangInterpret($familyShelterService);
        }
        if ($wheelchair) {
            $familyShelterService = new Wheelchair($familyShelterService);
        }

        $finalAccessLvl = $familyShelterService->showAccessLevel();
        $numberOfShelters=12;

        $isEventCreated = EventModel::CreateFamilyShelterEvent($eventName, $date,$capacity, $tickets, $numberOfShelters,$shelterLocation,$EventAttendanceCapacity ,$finalAccessLvl);
        
        return $isEventCreated;
    }
}

?>
