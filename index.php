<?php

require_once './controllers/loginController.php';
require_once './Database.php';
require_once './db-populate.php';


$db = new Database;
    // Populate the database if necessary
    // Populate::populate();
// Check and verify the database connection
if ($db->getConnection()) {

     //echo "$db->getConnection()";
    // Handle the request through LoginController
    $controller = new LoginController();
    $controller->handleRequest();
} else {
    echo "Failed to connect to the database.";
}
?>
