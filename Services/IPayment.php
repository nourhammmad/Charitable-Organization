<?php 
interface Ipayment{
    public function processPayment($donorid):bool;
    public function getPaymentDetails():string;
}