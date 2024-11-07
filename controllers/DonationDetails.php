<?php
session_start(); // Start the session at the beginning

//require_once './Services/RegisterUser.php';  // If needed

class DonationDetails {

    // Method to retrieve the user ID from the session
    function getUserID() { 
        // Check if the user ID is set in the session
        if (isset($_SESSION['user_id'])) {
            //echo "User ID found: " . $_SESSION['user_id'];  // You can remove echo later for debugging
            return $_SESSION['user_id'];  // Return the user ID stored in the session
        } else {
          //  echo "No user ID found in session.";  // For debugging purposes
            return null;  // If no user ID is found, return null
        }
    }

    // Method to handle the request and return the response
    function show() {
        if (isset($_POST['getid'])) {
            $id = $this->getUserID(); // Get the user ID
  

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
