<?php
require_once "D:/SDP/project/Charitable-Organization/Services/EducationalCenters.php"; 
require_once "D:/SDP/project/Charitable-Organization/Services/AccessabilityDecorator.php"; 
require_once "D:/SDP/project/Charitable-Organization/Services/SignLangInterpret.php";
require_once "D:/SDP/project/Charitable-Organization/Services/Wheelchair.php";
require_once "D:/SDP/project/Charitable-Organization/models/EventModel.php";

class EducationalCenterController {

    public static function createEducationalCenterEvent($eventName ,$date,$capacity ,$EventAttendanceCapacity, $tickets, $signLangInterpret, $wheelchair) {
       // $eventName="Educational Center";
       // $capacity=10;

    //Decorator
        $EducationalCentersService = new EducationalCenters($EventAttendanceCapacity, $capacity, 'Shelter Location'); // Example values for family shelter

        if ($signLangInterpret) {
            $EducationalCentersService = new SignLangInterpret($EducationalCentersService);
        }
        if ($wheelchair) {
            $EducationalCentersService = new Wheelchair($EducationalCentersService);
        }

        $finalAccessLvl = $EducationalCentersService->showAccessLevel();
        $numberOfShelters=12;
        $shelterLocation="cairo";

        $isEventCreated = EventModel::CreateEducationalCenters($eventName, $date, $tickets, $numberOfShelters,$shelterLocation,$EventAttendanceCapacity ,$finalAccessLvl);
        
        return $isEventCreated;
    }
}

?>
