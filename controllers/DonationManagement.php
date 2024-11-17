<?php
//$server = $_SERVER['DOCUMENT_ROOT'];
require_once "F:/senior 2/Design Patterns/project/Charitable-Organization/models/DonationModel.php";

class DonationManagement {
    public static function handelTrack($type) {
       
        // $bookDescription = ''; 
        // $clothesDescription = '';
        // $moneyDescription = '';

   
        if ($type==2) {
            $result = DonationModel::getDonationsByType($type);//2
            
            if ($result && $result->num_rows > 0) {
                echo json_encode($result->fetch_all(MYSQLI_ASSOC));
                exit();
            } else {
                echo "No books found.";
            }
        }

        // Handle Clothes Donation tracking
        elseif ($type==3) {
            $result = DonationModel::getDonationsByType($type);//3
            if ($result && $result->num_rows > 0) {
                echo json_encode($result->fetch_all(MYSQLI_ASSOC));
            } else {
                echo "No clothes found.";
            }
        }

        // Handle Money Donation tracking
        elseif ($type==1) {
            $result = DonationModel::getDonationsByType($type); //1
    
            if ($result && $result->num_rows > 0) {
                echo json_encode($result->fetch_all(MYSQLI_ASSOC));
            } else {
                echo "No money found.";
            }
        }

        // Handle the Clear action to reset all donation descriptions
        // elseif (isset($_POST['clear'])) {
        //     $bookDescription = '';
        //     $clothesDescription = '';
        //     $moneyDescription = '';
        // }

        // Include the view
       // require_once "D:/SDP/project/Charitable-Organization/views/testOrganization.php";
    }

    public function getUserinfo(DonationDetails $don) {
        $id = $don->getUserID();
        $info = RegisterUserTypeModel::findById($id);
        return $info;
    }
}
?>
