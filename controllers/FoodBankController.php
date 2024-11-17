<?php
require_once "D:/SDP/project/Charitable-Organization/Services/FoodBank.php"; 
require_once "D:/SDP/project/Charitable-Organization/Services/AccessabilityDecorator.php"; 
require_once "D:/SDP/project/Charitable-Organization/Services/SignLangInterpret.php"; 
require_once "D:/SDP/project/Charitable-Organization/Services/Wheelchair.php"; 
require_once "D:/SDP/project/Charitable-Organization/models/EventModel.php"; 

class FoodBankController {

    public static function createFoodBankEvent($eventName ,$date ,$capacity, $tickets, $signLangInterpret, $wheelchair) {
        $eventName="Food Bank";
        // $capacity=10;
        $foodQuantity=12;
        $foodType="VeggiesProtein";
        $foodBankLocation='cairo';
    //Decorator
        $foodbankService = new FoodBank($foodQuantity,$foodType, $foodBankLocation); // Example values for family shelter

        if ($signLangInterpret) {
            $foodbankService = new SignLangInterpret($foodbankService);
        }
        if ($wheelchair) {
            $foodbankService = new Wheelchair($foodbankService);
        }

        $finalAccessLvl = $foodbankService->showAccessLevel();
   

    
        $isEventCreated = EventModel::CreateFoodBankEvent($eventName, $date,$capacity,$tickets, $foodQuantity,$foodType ,$finalAccessLvl);
        
        return $isEventCreated;
    }
}

?>
