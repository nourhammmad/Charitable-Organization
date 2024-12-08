<?php

require_once  $_SERVER['DOCUMENT_ROOT']."\Services\Donor.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\DonationProvider.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\models\DonorModel.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\paymentMethods.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\models\donarLogFile.php";




if (isset($_POST['donorId']) && isset($_POST['donationType'])) {
    $donationType = $_POST['donationType'];
    $donorId =(int) $_POST['donorId'];
    $donationStrategy = null;

    switch ($donationType) {
        case 'book':
            $donationStrategy = new BooksDonation($_POST['bookTitle'], $_POST['author'], $_POST['publicationYear'], $_POST['quantity']);
            break;
        case 'clothes':
            $donationStrategy = new ClothesDonation($_POST['type'],$_POST['size'],$_POST['color'],$_POST['quantity']);
            break;
        case 'money':
            if($_POST['paymentType']=='cash')
             $donationStrategy = new FeesDonation($_POST['amount'],new cash($_POST['amount'],$_POST['currency']));

            else if($_POST['paymentType']=='visa'){
             $donationStrategy = new FeesDonation($_POST['amount'],new visa($_POST['amount'],$_POST['cardNumber'],$_POST['currency']));
            }

            // else if($_POST['paymentType']='instapay')
            //  $donationStrategy = new FeesDonation($_POST['amount'],new cash($_POST['amount'],$_POST['currency']));
            break;
        default:
            echo "Invalid donation type.";
            exit;
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
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'view_history') {
    header('Content-Type: application/json'); // Ensure JSON response

    $donorId = $_POST['donorId']; // Get donor ID from POST data

    try {
        $donations = donarLogFile::getLogsByUserId($donorId);
        if ($donations) {
            echo json_encode(['success' => true, 'donations' => $donations]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No donations found.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'An error occurred.', 'error' => $e->getMessage()]);
    }
    exit;
}


else {
    echo "Donor ID or Donation Type missing!";
}
