<?php

require_once "../Services/IPayment.php";

class cash implements Ipayment {
    private $amount;
    private $currencyType;

    public function __construct($amount,$currency)
    {
        $this->amount=$amount;
        $this->currencyType=$currency;
    }

    public function processPayment($donorid):bool{

        $transactionNumber = 'TRANS' . uniqid() . random_int(1000, 9999);
        $paymentDetails = [
            'donor_id' => $donorid, 
            'transaction_number' => $transactionNumber, 

        ];
        
        $result = DonationModel::createMoneyDonation(1, $this->amount, $this->currencyType, 'cash', $paymentDetails);

        if ($result) return true;
        return false;
    }
    
    public function getPaymentDetails():string{
        return 'Cash Payement method of '.$this->amount .' '.$this->currencyType;
    }

   // public function refund($amount): Bool;

}