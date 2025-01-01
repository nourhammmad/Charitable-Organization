<?php 
require_once "Database.php";
require_once "controllers\loginController.php";
require_once "db-populate.php";
require_once "controllers/OrganizationController.php";
require_once "models\UserModel.php";

$db = Database::getInstance();

// Check if the 'db_populated.flag' file exists
if (!file_exists("db_populated.flag")) {
    // If the flag file does not exist, run the populate function
    Populate::populate();
    
    // After populating the database, create the flag file
    file_put_contents("db_populated.flag", "Database populated successfully.");
}

if (Database::get_connection()) {
    $controller = new LoginController();
    $controller->handleRequest();
} else {
    echo "Failed to connect to the database.";
}
?>
