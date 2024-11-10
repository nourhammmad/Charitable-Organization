<?php

// //require_once "./models/OrganizationModel.php";
// //require_once "./models/EventModel.php";


// require_once "D:/SDP/project/Charitable-Organization/models/OrganizationModel.php";
// require_once "D:/SDP/project/Charitable-Organization/models/EventModel.php";



// class OrganizationController{

//     private $name;
//     private $donationManagement;
//     private $eventsManagement;
//     private $volunteeringManagement;

//     public static $instance = null; // Singleton instance

//     // Private constructor to prevent direct instantiation
//     public function __construct($name) {
//         $this->name = $name;
//         // $this->donationManagement = new DonationManagement($this);
//         // $this->eventsManagement = new EventsManagement($this);
//         // $this->volunteeringManagement = new VolunteeringManagement($this);
//     }

//     // Singleton method to get the single instance of Organization
//     public static function getInstance($name = "Default Organization") {
//         if (self::$instance === null) {
//             self::$instance = new self($name);
//         }
//         return self::$instance;
//     }




//     public function createEvent( $date, $address ,$EventAttendanceCapacity, $tickets){
//       $event=EventModel::createEvent($date, $address ,$EventAttendanceCapacity, $tickets);
//       if($event){
//         require_once "./views/yay.php";
//     } else {
//         echo "No organization found.";
//       }
//     }








// //getDonationManagement():DonationManagement
// //getEventsManagement():EventsManagement
// //getVolunteeringManagement() : VolunteerManagement





// public function handleRequest() {
//     // Handle organization registration
//     if (isset($_POST['get_registered_org'])) {
//         $this->showOrg(); // Call the function to show the organization
//     }
//     elseif (isset($_POST['get_donors'])){
//         $this->showDonors();
//     }
//     elseif(isset($_POST['createvent'])){
//          $this->createEvent($_POST['date'],null,$_POST['att'], $_POST['tickets']);
//     }
//     require_once "D:/SDP/project/Charitable-Organization/views/testOrganization.php";
// }

// public function showOrg() {
//     // Get the organization data
//     $result = OrganizationModel::getAllOrganizations();
//     if ($result) {
//         $organization = $result->fetch_assoc(); 
//         require_once "./views/yay.php";
//     } else {
//         echo "No organization found.";
//     }
// }




// public static function getDonors() {
//     $query = "SELECT * FROM Donor";
//     $res = Database::run_select_query(query: $query);
//     return $res;
// }


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
// }





// }



?>