<?php
require_once $_SERVER['DOCUMENT_ROOT']."\Services\FoodBank.php"; 
require_once $_SERVER['DOCUMENT_ROOT']."\Services\AccessabilityDecorator.php"; 
require_once $_SERVER['DOCUMENT_ROOT']."\Services\SignLangInterpret.php"; 
require_once $_SERVER['DOCUMENT_ROOT']."\Services\Wheelchair.php"; 
require_once $_SERVER['DOCUMENT_ROOT']."\models\EventModel.php"; 

class FoodBankController {

    public static function createFoodBankEvent($eventName ,$date ,$capacity, $tickets,$shelterLocation ,$signLangInterpret, $wheelchair) {
       
        $foodQuantity=12;
        $foodType="VeggiesProtein";
  
        $foodbankService = new FoodBank($foodQuantity,$foodType, $shelterLocation); 

        if ($signLangInterpret) {
            $foodbankService = new SignLangInterpret($foodbankService);
        }
        if ($wheelchair) {
            $foodbankService = new Wheelchair($foodbankService);
        }

        $finalAccessLvl = $foodbankService->showAccessLevel();
   

    
        $isEventCreated = EventModel::CreateFoodBankEvent($eventName, $date,$capacity,$tickets, $foodQuantity,$foodType, $shelterLocation ,$finalAccessLvl);
        
        return $isEventCreated;
    }
}

?>
