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

// class FeesDonation implements Donation {
//     public function donate($donorId, $amount) {
//         // Logic for donating fees
//         $paymentId = DonationModel::createPayment('cash'); // Assuming a cash payment for simplicity
//         DonationModel::createMoneyDonation($donorId, $amount, $paymentId);
//     }
// }

// class ClothesDonation implements Donation {
//     public function donate($donorId, $quantity) {
//         // Logic for donating clothes
//         DonationModel::createDonationType($donorId, $quantity);
//         // Any additional logic for clothes
//     }
// }



// class ClothesDonation extends Donation {
//     private $clothesType;

//     public function __construct($donationId, $quantityDonated, $clothesType) {
//         parent::__construct($donationId, $quantityDonated);
//         $this->clothesType = $clothesType;
//     }

//     public function donate($donorId, $quantity) {
        
//         DonationModel::createDonationType($donorId, $quantity);
//         // Any additional logic for books
//     }
// }

// class BooksDonation extends Donation {
//     private $genre;

//     public function __construct($donationId, $quantityDonated, $genre) {
//         parent::__construct($donationId, $quantityDonated);
//         $this->genre = $genre;
//     }

//     public function donate(): bool {
//         echo "Donating " . $this->quantityDonated . " books of genre: " . $this->genre . ".\n";
//         return true;
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