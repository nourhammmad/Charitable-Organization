<?php
session_start(); // Start the session at the beginning

//require_once './Services/RegisterUser.php';  // If needed

class DonationDetails {


    function getUserID() { 
    
        if (isset($_SESSION['user_id'])) {
            return $_SESSION['user_id']; 
        } else {
            return null; 
        }
    }

  
    function show() {
        if (isset($_POST['getid'])) {
            $id = $this->getUserID(); 
  

            if ($id) {
                // Display the user ID in plain text or HTML
                echo "User ID: " . $id;
            } else {
                // Display an error message if no user ID is found in session
                echo "No user found.";
            }
        } else {
            // Handle invalid request
            echo "Invalid request.";
        }
    }
}

// Check if this script is accessed via POST to handle the request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $donationDetails = new DonationDetails();
    $donationDetails->show();  // Handle the request and return the response
}
?>
