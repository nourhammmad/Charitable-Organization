<?php 
//$server=$_SERVER['DOCUMENT_ROOT'];
require_once $_SERVER['DOCUMENT_ROOT']."\Services\IServices.php";


abstract class AcessabilityDecorator implements IServices{
    public IServices $ref;
    public function __construct(IServices $service) {
        $this->ref = $service; 
    }
    public function getRef(): IServices{
        return $this->ref;
    }
}