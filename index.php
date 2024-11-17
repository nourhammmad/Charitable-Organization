<?php

require_once "../Charitable-Organization/Database.php";
require_once "../Charitable-Organization/controllers/loginController.php";
require_once "../Charitable-Organization/db-populate.php";
require_once "../Charitable-Organization/controllers/OrganizationController.php";
require_once "../Charitable-Organization/models/UserModel.php";



$db = Database::getInstance();
Populate::populate();


if (Database::get_connection()) {
    $controller = new LoginController();
 //  $controller = new OrganizationController('My Charitable Organization');
 $controller->handleRequest();
} else {
    echo "Failed to connect to the database.";
}

// $registerUser = new RegisterUser("volunteer@example.com", "VolunteerName", "Volunteer");
// $registerUser->signUp();

// // Test: Display available events for a volunteer with ID 1
// $volunteerController = new VolunteerController(1);
// $volunteerController->displayAvailableEvents();

// // Test: Apply for an event with ID 2 for the volunteer with ID 1
// $volunteerController->applyForEvent(2);

?>
