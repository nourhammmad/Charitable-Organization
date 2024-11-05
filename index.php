<?php

require_once "../Charitable-Organization/Database.php";
require_once "../Charitable-Organization/controllers/loginController.php";
require_once "../Charitable-Organization/db-populate.php";

require_once "../Charitable-Organization/models/UserModel.php";

// Initialize the database connection
$db = new Database();
Populate::populate();


if ($db->getConnection()) {
    $controller = new LoginController();
    $controller->handleRequest();
} else {
    echo "Failed to connect to the database.";
}

?>
