<?php

require_once "Database.php";
require_once "db-populate.php";

$database = new Database();
if ($database->conn) {
    $populate = new Populate($database);
    $populate->populate();
    echo "Database connected and populated successfully!";
} else {
    echo "Failed to connect to the database.";
}

