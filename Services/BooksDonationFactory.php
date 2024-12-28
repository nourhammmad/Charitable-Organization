<?php
require_once $_SERVER['DOCUMENT_ROOT']."/Services/DonationProvider.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/DonationFactory.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\models\RegisteredUserModel.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\Donor.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\models\DonorModel.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\paymentMethods.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\models\donarLogFile.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\DonationLog.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\CreateState.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\UndoDonationCommand.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\RedoDonationCommand.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\RedoOnlyState.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\DonationLogIterator.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\DonationLogIterable.php";

class BooksDonationFactory extends DonationFactory{
    static function createDonation($donationType, $donorId, $type, $size, $color, $quantity, $title, $author, $year, $amount, $currency, $cardNumber){
    
        $donationStrategy = new BooksDonation($title, $author, $year,  $quantity);
                  
        
        if ($donationStrategy) {
            $donor = DonarModel::getDonorById($donorId);
        
            if($donor){
                $donor->setDonationStrategy($donationStrategy);
        
                if ($donor->donate($donorId)) {
                    $donarLog= donarLogFile::getLastLogByDonorId($donorId);    
                    $donarLog->setDonationState(new CreateState());
                    echo ucfirst($donationType) . " donation successful!";
                    } 
                else {
                        echo "Failed to donate " . $donationType . ".";
                    }
            }
            else{
                    echo "coudnot create donor";
                }
                    
                // if (isset($_GET['type'])) {
        //     try {
        //         $type = $_GET['type'];
        //         // $config = ModalConfigFactory::getConfig($type);
        //         echo json_encode($config);
        //     } catch (Exception $e) {
        //         echo json_encode(['error' => $e->getMessage()]);
        //     }
        // }
    
        }
    }

}


