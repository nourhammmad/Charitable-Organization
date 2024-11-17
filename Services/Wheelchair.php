<?php 
$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server."./Services/AccessabilityDecorator.php";

class Wheelchair extends AcessabilityDecorator{
    
    public function showAccessLevel():int{
        return 100 + $this->getRef()->showAccessLevel();
    }

}