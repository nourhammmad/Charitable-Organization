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

        $result = DonationModel::createMoneyDonation(1,1,$this->amount, $this->currencyType, 'cash', $paymentDetails);

        if ($result) return true;
        return false;
    }

    public function getPaymentDetails():string{
        return 'Cash Payement method of '.$this->amount .' '.$this->currencyType;
    }

   // public function refund($amount): Bool;
}
class visa implements Ipayment {
    private $amount;
    private $cardNumber;
    private $currency;
    // private $expiryDate;
    // private $CVV;
    public function __construct($amount,$cardNumber,$currency)
    {
        $this->amount=$amount;
        $this->cardNumber=$cardNumber;
        $this->currency=$currency;
        // $this->cardHolderName=$cardHolderName;
        // $this->expiryDate=$expiryDate;
        // $this->CVV=$CVV;
    }
    public function processPayment($donorid):bool{
        echo "in visa \n";
        $transactionNumber = 'TRANS' . uniqid() . random_int(1000, 9999);
        $paymentDetails = [
            'donor_id' => $donorid, 
            'cardNumber' => $this->cardNumber,
            'transaction_number'=> $transactionNumber

        ];
        //should have an api to be called 
        $result = DonationModel::createMoneyDonation(1,1, $this->amount,'USD', 'visa', $paymentDetails);
        if ($result) return true;
        return false;
    }
    
    public function getPaymentDetails():string{
        return 'Visa Payement method of '.$this->amount .' '.$this->currency;
    }
   // public function refund($amount): Bool;
}