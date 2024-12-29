<?php
require_once $_SERVER['DOCUMENT_ROOT']."\Services\EducationalCenters.php"; 
require_once $_SERVER['DOCUMENT_ROOT']."\Services\AccessabilityDecorator.php"; 
require_once $_SERVER['DOCUMENT_ROOT']."\Services\SignLangInterpret.php";
require_once $_SERVER['DOCUMENT_ROOT']."\Services\Wheelchair.php";
require_once $_SERVER['DOCUMENT_ROOT']."\models\EventModel.php";

class EducationalCenterController {

    public static function createEducationalCenterEvent($eventName ,$date,$capacity ,$EventAttendanceCapacity, $tickets, $shelterLocation ,$signLangInterpret, $wheelchair) {
       // $eventName="Educational Center";
       // $capacity=10;

 echo"dcbhjgdcjhdbckjdbc";
 echo $shelterLocation;
        $EducationalCentersService = new EducationalCenters($EventAttendanceCapacity, $capacity, $shelterLocation); 

        if ($signLangInterpret) {
            $EducationalCentersService = new SignLangInterpret($EducationalCentersService);
        }
        if ($wheelchair) {
            $EducationalCentersService = new Wheelchair($EducationalCentersService);
        }

        $finalAccessLvl = $EducationalCentersService->showAccessLevel();
        $numberOfShelters=12;

        $isEventCreated = EventModel::CreateEducationalCenters($eventName, $date,$EventAttendanceCapacity , $tickets, $numberOfShelters,$shelterLocation,$finalAccessLvl);
        
        return $isEventCreated;
    }
}

?>
