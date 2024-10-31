<?php
// database.php

$servername = "localhost"; // MySQL server
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP (usually empty)
$dbname = "charityORG"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname,$port=3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
