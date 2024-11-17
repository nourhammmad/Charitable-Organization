<?php 
//$server=$_SERVER['DOCUMENT_ROOT'];
require_once "F:/senior 2/Design Patterns/project/Charitable-Organization/Services/IServices.php";

abstract class AcessabilityDecorator implements IServices{
    public IServices $ref;
    public function __construct(IServices $service) {
        $this->ref = $service; // Initialize the property
    }
    public function getRef(): IServices{
        return $this->ref;
    }
}