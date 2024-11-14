<?php
$server = $_SERVER['DOCUMENT_ROOT'];
require_once $server . './models/OrganizationModel.php';
require_once $server . './models/EventModel.php';
require_once $server . './controllers/DonationManagement.php';

class OrganizationController {

    private $name;
    private $donationManagement;
    private $eventsManagement;
    private $volunteeringManagement;
public function __construct($name) {
    $this->name = $name;

}


    public function createEvent($date, $EventAttendanceCapacity, $tickets) {
        // Call the createEvent method from the model
        $eventId = EventModel::createEvent($date, $EventAttendanceCapacity, $tickets);

        // Check if the event ID was successfully returned
        if ($eventId) {
            // Retrieve the event details using the ID
            $event = EventModel::getEventById($eventId);

            // Check if event details were retrieved
            if ($event && is_array($event)) {
                // Event was created and retrieved successfully, pass the event details to the view
                // We don't need to echo anything here, we'll handle passing the data directly
                $server = $_SERVER['DOCUMENT_ROOT'];
                require_once $server . "./views/yay.php"; // Ensure this view handles the event creation info.
            } else {
                echo "Error retrieving event details.";
            }
        } else {
            echo "Event creation failed.";
        }
    }

    public function handleRequest() {
        // Start the session at the beginning of the method (if not done already)
    
     
    
        // Initialize default values for descriptions to avoid undefined variable warnings
        $bookDescription = isset($_POST['book_description']) ? $_POST['book_description'] : '';
        $clothesDescription = isset($_POST['clothes_description']) ? $_POST['clothes_description'] : '';
        $moneyDescription = isset($_POST['money_description']) ? $_POST['money_description'] : '';
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Handle different actions based on the POST request
            if (isset($_POST['get_org'])) {
                OrganizationController::showOrg();
            } elseif (isset($_POST['get_donors'])) {
                OrganizationController::showDonors();
            } elseif (isset($_POST['track_books']) || isset($_POST['track_clothes']) || isset($_POST['track_money'])) {
                DonationManagement::handelTrack();
            } elseif (isset($_POST['create_event'])) {
                // Handle event creation
                $date = $_POST['event_date'];
                $address = $_POST['event_address'];
                $capacity = $_POST['event_capacity'];
                $tickets = $_POST['event_tickets'];
    
                // Create the event
                $this->createEvent($date, $capacity, $tickets);
            }
        }
    
        // After handling the request, pass the variables to the view
        $server = $_SERVER['DOCUMENT_ROOT'];
        require_once $server . "./views/testOrganization.php";
    }
    
    // Show organization data
    public function showOrg() {
        $result = OrganizationModel::getAllOrganizations();
        if ($result) {
            $organization = $result->fetch_assoc(); // Fetch organization data
            // Show the organization data in the view
            require_once "./views/yay.php";
            exit();
        } else {
            echo "No organization found.";
        }
    }

    // Show the donors data
    public function showDonors() {
        $donors = OrganizationModel::getDonors();

        if ($donors) {
            $donorsData = [];
            while ($donor = $donors->fetch_assoc()) {
                $donorsData[] = $donor; // Store all donors in an array
            }
            // Pass the donors data to the view
            $server = $_SERVER['DOCUMENT_ROOT'];
            require_once $server . "./views/yay.php";
        } else {
            echo "No donors found.";
        }
    }

    // Static method to get all donors
    public static function getDonors() {
        $query = "SELECT * FROM Donor";
        $res = Database::run_select_query(query: $query);
        return $res;
    }
}
?>
