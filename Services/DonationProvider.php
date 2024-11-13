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

    public function donate():bool {
        if(DonationModel::createBookDonation(2,1,$this->bookTitle,$this->author,$this->publicationYear,$this->getQuantity())){
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

    public function donate():bool {
        if(DonationModel::createClothesDonation(2,1,$this->clothesType,$this->size,$this->color,$this->getQuantity())){
            return true;
        }
        return false;

    }
}

// class FeesDonation implements Donation {
//     public function donate($donorId, $amount) {
//         // Logic for donating fees
//         $paymentId = DonationModel::createPayment('cash'); // Assuming a cash payment for simplicity
//         DonationModel::createMoneyDonation($donorId, $amount, $paymentId);
//     }
// }


// class FeesDonation extends Donation {
//     private $purpose;

//     public function __construct($donationId, $quantityDonated, $purpose) {
//         parent::__construct($donationId, $quantityDonated);
//         $this->purpose = $purpose;
//     }

//     public function donate(): bool {
//         echo "Donating $" . $this->quantityDonated . " for " . $this->purpose . ".\n";
//         return true;
//     }
// }