<?php
// require_once "../Services/DonationType.php";
// require_once "../Services/ContextAuthenticator.php";
require_once "./Services/User.php";




class Guest extends user{


    public function __construct() {
        parent::__construct('Guest');
    }

    public function getUserType() {
    return $this->type;
    }
   
    public function login() {
        $_SESSION['user_id'] = $this->userid;
        $_SESSION['user_type'] = $this->type;
        header("Location: ./views/HomeView.php");
        exit();
    }
    
   
    // public function getDonationType() {
    //     return $this->donation;
    // }

    
    // public function setDonationType($donationtype) {
    //     $this->donation = $donationtype;
    // }

    // public function donate(DonationType $donationModel, $quantity, $type) {
    //     // Ensure user is logged in by checking the session
    //     if (!isset($_SESSION['user_id'])) {
    //         echo "User not logged in.";
    //         return;
    //     }
    
    //     $userId = $_SESSION['user_id'];
 
    //     $result = $donationModel->addDonation($userId, $quantity, $type);
    //     //!! ana msh 3arfa shakl el mdel hena 3amel ezay fa msh 3arfa a update!!//
    
    //     if ($result) {
    //         echo "Donation successfully recorded!";
    //     } else {
    //         echo "Failed to record donation.";
    //     }
    // }
    
}

?>