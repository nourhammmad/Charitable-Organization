<?php

require_once "../Services/Donor.php";
require_once "../Services/DonationProvider.php";
require_once "../models/DonorModel.php";


if (isset($_POST['donorId']) && isset($_POST['donationType'])) {
    $donationType = $_POST['donationType'];
    $donorId =(int) $_POST['donorId'];
    $donationStrategy = null;

    switch ($donationType) {
        case 'book':
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
        $donor = DonarModel::getDonorById($donorId);

        if($donor){
            $donor->setDonationStrategy($donationStrategy);
            if ($donor->donate($donorId)) {
                echo ucfirst($donationType) . " donation successful!";
            } 
            else {
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
