<?php




// //require_once "./models/OrganizationModel.php";
// //require_once "./models/EventModel.php";


require_once "D:/SDP/project/Charitable-Organization/models/OrganizationModel.php";
require_once "D:/SDP/project/Charitable-Organization/models/EventModel.php";
require_once "D:/SDP/project/Charitable-Organization/controllers/DonationManagement.php";




class OrganizationController{

    private $name;
    private $donationManagement;
    private $eventsManagement;
    private $volunteeringManagement;

    // public static $instance = null; // Singleton instance

    // // Private constructor to prevent direct instantiation
    // public function __construct($name) {
    //     $this->name = $name;
    //     $this->donationManagement = new DonationManagement($this);
    //     // $this->eventsManagement = new EventsManagement($this);
    //     // $this->volunteeringManagement = new VolunteeringManagement($this);
    // }

    // // Singleton method to get the single instance of Organization
    // public static function getInstance($name = "Default Organization") {
    //     if (self::$instance === null) {
    //         self::$instance = new self($name);
    //     }
    //     return self::$instance;
    // }




    public function createEvent( $date, $address ,$EventAttendanceCapacity, $tickets){
      $event=EventModel::createEvent($date, $address ,$EventAttendanceCapacity, $tickets);
      if($event){
        require_once "./views/yay.php";
    } else {
        echo "No organization found.";
      }
    }








//getDonationManagement():DonationManagement
//getEventsManagement():EventsManagement
//getVolunteeringManagement() : VolunteerManagement





public  function handleRequest() {
    echo "   ana f handle"; 
  

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "Request Method: " . $_SERVER['REQUEST_METHOD'] . "<br>";
    
        // Print the full URL
        $fullUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        echo "Request URL: " . $fullUrl;


        // echo"        post    ";
        // echo"fo2";
        // echo $_POST['get_org'];
        // echo"t7t";
        if (isset($_POST['get_org'])) {
            echo "ana mawsltsh 222";
            OrganizationController::showOrg();
            echo "ana mawsltsh 333";
        } elseif (isset($_POST['get_donors'])) {
            OrganizationController::showDonors();
        } elseif (isset($_POST['track_books']) || isset($_POST['track_clothes']) || isset($_POST['track_money'])) {
            DonationManagement::handelTrack();
        }
    }
    require_once "D:/SDP/project/Charitable-Organization/views/testOrganization.php";

}



// public static function login() {
//     require_once "D:/SDP/project/Charitable-Organization/views/testOrganization.php";

//    // exit();
// }

public function showOrg() {
    // Get the organization data
    $result = OrganizationModel::getAllOrganizations();
    if ($result) {
        $organization = $result->fetch_assoc(); // Store organization data
        // // Now pass the data to the view
        // session_start(); // Start the session to store data
        //  $_SESSION['organization'] = $organization; // Store the organization data in session
         require_once "D:/SDP/project/Charitable-Organization/views/yay.php"; 

         //header("Location: /views/yay.php");
exit(); // Always call exit after redirect to stop further processing

    } else {
        echo "No organization found.";
    }
}


public  function showDonors() {

    $donors = OrganizationModel::getDonors();

    if ($donors) {
        $donorsData = [];
        while ($donor = $donors->fetch_assoc()) {
            $donorsData[] = $donor;
        }
      
        require_once "./views/yay.php"; 
    } else {
      
        echo "No donors found.";
    }
}





public static function getDonors() {
    $query = "SELECT * FROM Donor";
    $res = Database::run_select_query(query: $query);
    return $res;
}


// public function showDonors() {
//     // Get the donors data
//     $donors = OrganizationModel::getDonors();

//     // If data exists, fetch it and pass it to the view
//     if ($donors) {
//         $donorsData = [];
//         while ($donor = $donors->fetch_assoc()) {
//             $donorsData[] = $donor; // Store all donors in an array
//         }
//         // Pass the donors data to the view
//         require_once "./views/yay.php";
//     } else {
//         // Optionally handle the case where no donors are found
//         echo "No donors found.";
//     }
}









?>