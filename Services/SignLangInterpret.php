<?php 
//$server=$_SERVER['DOCUMENT_ROOT'];
require_once "Services\AccessabilityDecorator.php";

class SignLangInterpret extends AcessabilityDecorator{
    
    public function showAccessLevel():int{
        return 150 + $this->getRef()->showAccessLevel();
    }

}