<?php
require_once ('E:\brwana\Gam3a\Senoir 2\Design Patterns\Project\Charitable-Organization\Database.php'); // Adjust path if needed

$database = new Database();
if ($database->getDbh()) {
    echo "Database connected successfully!";
} else {
    echo "Failed to connect to the database.";
}
