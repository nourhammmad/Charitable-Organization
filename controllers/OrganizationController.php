<?php

require_once $_SERVER['DOCUMENT_ROOT'].'./models/OrganizationModel.php';
require_once $_SERVER['DOCUMENT_ROOT'].'./models/EventModel.php';
require_once $_SERVER['DOCUMENT_ROOT'].'./controllers/DonationManagement.php';

require_once $_SERVER['DOCUMENT_ROOT']."./models/OrganizationModel.php";
require_once  $_SERVER['DOCUMENT_ROOT']."./controllers/FamilyShelterController.php";



class OrganizationController {

    public static function createEvent($date, $address, $capacity, $tickets) {
        $eventId = EventModel::createEvent($date, $capacity, $tickets);

        if ($eventId) {
            $event = EventModel::getEventById($eventId);
            if ($event && is_array($event)) {
                echo "mazboot";

            } else {
                echo "Error retrieving event details.";
            }
        } else {
            echo "Event creation failed.";
        }
    }
}



if (isset($_GET['action'])) {

    $action = $_GET['action'];
echo $action;
    switch ($action) {
        case 'getOrganizations':
            handleGetOrganizations();
            break;

        case 'getDonors':
            handleGetDonors();
            break;

        case 'createEvent':
            handleCreateEvent();
            break;

        case 'trackBooks':
            handleBooks();
            break;

        case 'trackClothes':
            handleClothes();
            break;

        case 'trackMoney':
            handleMoney();
            break;

        default:
            echo "Invalid action.";
            break;
    }
}

function handleGetOrganizations() {
    $result = OrganizationModel::getAllOrganizations();
    if ($result && $result->num_rows > 0) {
        echo json_encode($result->fetch_all(MYSQLI_ASSOC));
    } else {
        echo "No organizations found.";
    }
}

function handleGetDonors() {
    $result = OrganizationModel::getDonors();
    if ($result && $result->num_rows > 0) {
        echo json_encode($result->fetch_all(MYSQLI_ASSOC));
    } else {
        echo "No donors found.";
    }
}

function handleCreateEvent() {
    // Sanitize and check POST values
    $date = $_POST['date'] ?? null;
    $address = $_POST['address'] ?? null;
    $capacity = $_POST['capacity'] ?? null;
    $tickets = $_POST['tickets'] ?? null;
    $service = $_POST['service'] ?? null;
    $signLangInterpret = isset($_POST['signLang']) ? true : false;
    $wheelchair = isset($_POST['wheelchair']) ? true : false;

    // Validate required fields
    if (!$date || !$address || !$capacity || !$tickets || !$service) {
        echo "Missing required fields: date, address, capacity, tickets, and service are mandatory.";
        return;
    }

    // Determine the service type
    $familyShelter = ($service === 'familyShelter');
    $educationalCenter = ($service === 'educationalCenter');
    $foodBank = ($service === 'foodBank');
    //public static function createFamilyShelterEvent($eventName, $date, $EventAttendanceCapacity, $tickets, $signLangInterpret, $wheelchair) {

    // Call the method to create the event, passing in the necessary parameters
    $isEventCreated = FamilyShelterController::createFamilyShelterEvent(
        'Family Shelter Event', // Example event name
        $date,
        $capacity,
        $tickets,
        $signLangInterpret,
        $wheelchair
    );
    if ($isEventCreated) {
        echo "Event created successfully.";
    } else {
        echo "Failed to create event. Please try again.";
    }

}

function handleBooks() {
   // echo"ana f handle books fel cont ";
    DonationManagement::handelTrack(2);
    echo "Books tracked successfully.";
    exit();
}

function handleClothes() {
    DonationManagement::handelTrack(3);
    echo "Clothes tracked successfully.";
}

function handleMoney() {
    DonationManagement::handelTrack(1);
    echo "Money tracked successfully.";
}

?>