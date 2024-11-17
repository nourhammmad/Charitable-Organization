<?php

require_once 'D:/SDP/project/Charitable-Organization/models/OrganizationModel.php';
require_once 'D:/SDP/project/Charitable-Organization/models/EventModel.php';
require_once 'D:/SDP/project/Charitable-Organization/controllers/DonationManagement.php';

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



require_once "D:/SDP/project/Charitable-Organization/models/OrganizationModel.php";

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
    $date = $_POST['date'] ?? null;
    $address = $_POST['address'] ?? null;
    $capacity = $_POST['capacity'] ?? null;
    $tickets = $_POST['tickets'] ?? null;

    if ($date && $address && $capacity && $tickets) {
        OrganizationController::createEvent($date, $address, $capacity, $tickets);
        echo "Event created successfully.";
    } else {
        echo "Missing required fields.";
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