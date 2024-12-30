<?php

require_once "Database.php";
require_once "controllers\loginController.php";
require_once "db-populate.php";
require_once "controllers/OrganizationController.php";
require_once "models/UserModel.php";

$db = Database::getInstance();
//Populate::populate();


if (Database::get_connection()) {
    $controller = new LoginController();

    $controller->handleRequest();
} else {
    echo "Failed to connect to the database.";
    
}

?>
