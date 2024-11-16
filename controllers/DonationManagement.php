<?php
$server = $_SERVER['DOCUMENT_ROOT'];
require_once $server."./models/DonationModel.php";

class DonationManagement {
    public static function handelTrack() {
        // Initialize variables for descriptions
        $bookDescription = ''; 
        $clothesDescription = '';
        $moneyDescription = '';

        // Handle Book Donation tracking
        if (isset($_POST['track_books'])) {
            $result = DonationModel::getDonationsByType(2);
    
            if ($result && $result->num_rows > 0) {
                $donation = $result->fetch_assoc();
                $bookDescription = $donation['description'] ?? 'No description available for book donations.';
            } else {
                $bookDescription = 'No book donations found.';
            }
        }

        // Handle Clothes Donation tracking
        elseif (isset($_POST['track_clothes'])) {
            $result = DonationModel::getDonationsByType(3);
    
            if ($result && $result->num_rows > 0) {
                $donation = $result->fetch_assoc();
                $clothesDescription = $donation['description'] ?? 'No description available for clothes donations.';
            } else {
                $clothesDescription = 'No clothes donations found.';
            }
        }

        // Handle Money Donation tracking
        elseif (isset($_POST['track_money'])) {
            $result = DonationModel::getDonationsByType(1);
    
            if ($result && $result->num_rows > 0) {
                $donation = $result->fetch_assoc();
                $moneyDescription = $donation['description'] ?? 'No description available for money donations.';
            } else {
                $moneyDescription = 'No money donations found.';
            }
        }

        // Handle the Clear action to reset all donation descriptions
        elseif (isset($_POST['clear'])) {
            $bookDescription = '';
            $clothesDescription = '';
            $moneyDescription = '';
        }

        // Include the view
        require_once "D:/SDP/project/Charitable-Organization/views/testOrganization.php";
    }

    public function getUserinfo(DonationDetails $don) {
        $id = $don->getUserID();
        $info = RegisterUserTypeModel::findById($id);
        return $info;
    }
}
?>
