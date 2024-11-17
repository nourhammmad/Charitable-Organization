<?php 
//$server=$_SERVER['DOCUMENT_ROOT'];
require_once "D:/SDP/project/Charitable-Organization/Services/AccessabilityDecorator.php";

class SignLangInterpret extends AcessabilityDecorator{
    
    public function showAccessLevel():int{
        return 150 + $this->getRef()->showAccessLevel();
    }

}