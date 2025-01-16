<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/VolunteerController.php';
error_log("volunteerRoute.php reached");
// Call the handleRequest method of VolunteerController
VolunteerController::handleRequest();


?>
