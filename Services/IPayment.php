<?php 
interface Ipayment{
    public function processPayment($donorid):bool;
    public function getPaymentDetails():string;
    //will be implemented later ..
    //public function refund($amount): Bool;
}