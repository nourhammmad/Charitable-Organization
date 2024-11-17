<?php 
//$server=$_SERVER['DOCUMENT_ROOT'];
require_once "F:/senior 2/Design Patterns/project/Charitable-Organization/Services/AccessabilityDecorator.php";

class Wheelchair extends AcessabilityDecorator{
    
    public function showAccessLevel():int{
        return 100 + $this->getRef()->showAccessLevel();
    }

}