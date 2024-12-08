<?php
require_once "../Services/Donation.php";
require_once "../models/DonationModel.php";


class BooksDonation extends DonationType {

    private $bookTitle;
    private $author;
    private $publicationYear;

    public function __construct($bookTitle,$author,$publicationYear,$quantity)
    {
        parent::__construct(2,$quantity);
        $this->bookTitle=$bookTitle;
        $this->author=$author;
        $this->publicationYear=$publicationYear; 
    }

    public function donate($donorid):bool {
        if(DonationModel::createBookDonation(2,1,$this->bookTitle,$this->author,$this->publicationYear,$this->getQuantity(),$donorid)){
            return true;
        }
        return false;

    }
}


class ClothesDonation extends DonationType {
    private $clothesType;
    private $size;
    private $color;

    public function __construct($clothesType,$size,$color,$quantity)
    {
        parent::__construct(3,$quantity);
        $this->clothesType=$clothesType;
        $this->size=$size;
        $this->color=$color; 
    }

    public function donate($donorid):bool {
        if(DonationModel::createClothesDonation(2,1,$this->clothesType,$this->size,$this->color,$this->getQuantity(),$donorid)){
            return true;
        }
        return false;

    }
}

class FeesDonation extends DonationType {
    private Ipayment $paymentMethod;
    

    public function __construct($amount, Ipayment $paymentMethod)
    {
        parent::__construct(1,$amount);
        $this->paymentMethod=$paymentMethod;
    }
    public function setProvider(Ipayment $paymentMethod)
    {

        $this->paymentMethod = $paymentMethod;
    } public function donate($donorid):bool {
        if ($this->paymentMethod->processPayment($donorid)) return true;
        return false;
       
    }
}