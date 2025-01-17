<?php
require_once $_SERVER['DOCUMENT_ROOT'] ."/Services/IPayment.php";
require_once $_SERVER['DOCUMENT_ROOT']."\Services\stripe.php";

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

   
}
class visa implements Ipayment {
    private $amount;
    private $cardNumber;
    private $currency;

    public function __construct($amount,$cardNumber,$currency)
    {
        $this->amount=$amount;
        $this->cardNumber=$cardNumber;
        $this->currency=$currency;
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
   
}


class StripeAdapter implements IPayment {
    private $stripe;
    private $amount;
    private $currency;
    private $source;

    public function __construct($amount, $currency,$source) {
        // that is my key changeable 
        $this->stripe = new StripeAPI('sk_test_51QaePV4GWzjxbbm42aSZO32l88EVahFlXmEQ696UoSU9vQv4IMQaKaEJwvmPpUVjETQ1x4pa9DrsxxK06djxb5ZU00rE5nBW8L');
        $this->amount = $amount;
        $this->currency = $currency;
        $this->source = $source;
    }

    public function processPayment($donorId): bool {
    try{
        // Charge via Stripe API
        $res= $this->stripe->charge($this->amount, $this->currency,$this->source);
        //after that db save
        if($res){
            echo "in stripe \n";
            $paymentDetails = [
                'donor_id' => $donorId, 
                'transaction_reference' => $this->source,
                'stripe_account'=> $this->stripe->getApikey(),

            ];
            $result = DonationModel::createMoneyDonation(1,1, $this->amount,$this->currency, 'stripe', $paymentDetails);
            if ($result) return true;
            return false;

        }
        return false;

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
        
    }

    public function getPaymentDetails(): string {
        return $this->stripe->getTransactionDetails();
    }
}