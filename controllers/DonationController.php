<?php
echo "Donation Controller reached";
// echo "POST data: ";
// print_r($_POST);
// require_once "../models/DonationModel.php";
// require_once "../Services/DonationType.php";
require_once "../Services/Donor.php";
require_once "../Services/DonationProvider.php";
require_once "../models/RegisteredUserModel.php";
// require_once "../Services/BooksDonation.php";
// require_once "../Services/FeesDonation.php";

if (isset($_POST['donorId']) && isset($_POST['donationType'])) {
    $donationType = $_POST['donationType'];
    $donorId = $_POST['donorId'];
    $donationStrategy = null;

    switch ($donationType) {
        case 'book':
            echo "inside case";
            $donationStrategy = new BooksDonation($_POST['bookTitle'], $_POST['author'], $_POST['publicationYear'], $_POST['quantity']);
            break;
        // case 'fees':
        //     $donationStrategy = new FeesDonation($_POST['amount']);
        //     break;
        // default:
        //     echo "Invalid donation type.";
        //     exit;
    }
    if ($donationStrategy) {
        $donor = RegisterUserTypeModel::getDonorById($donorId);
        if($donor){
            $donor->setDonationStrategy($donationStrategy);
            echo "made strategy";
            if ($donor->donate($donorId, $_POST['quantity'])) {
                echo ucfirst($donationType) . " donation successful!";
            } else {
                echo "Failed to donate " . $donationType . ".";
            }
        }
        else{
            echo "coudnot create donor";
        }
    }
}

else {
    echo "Donor ID or Donation Type missing!";
}
