<?php
$server = $_SERVER['DOCUMENT_ROOT'];
require_once $server.'./models/OrganizationModel.php';
require_once $server.'./models/EventModel.php';
require_once $server.'./controllers/DonationManagement.php';

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



require_once $server . "./controllers/FamilyShelterController.php";
// Include the EventModel class

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
            // Check if the HTTP method is POST before calling handleCreateEvent
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                handleCreateEvent();
            } else {
                echo "Invalid request method. Please use POST.";
            }
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

    // Call the method to create the event, passing in the necessary parameters
    $isEventCreated = FamilyShelterController::createFamilyShelterEvent(
        'Family Shelter Event', // Example event name
        $date,
        $capacity,
        $tickets,
        $familyShelter,
        $educationalCenter,
        $foodBank,
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
    if (DonationManagement::handelTrack(2)) {
        echo "Books tracked successfully.";
    } else {
        echo "Failed to track books.";
    }
}

function handleClothes() {
    if (DonationManagement::handelTrack(3)) {
        echo "Clothes tracked successfully.";
    } else {
        echo "Failed to track clothes.";
    }
}

function handleMoney() {
    if (DonationManagement::handelTrack(1)) {
        echo "Money tracked successfully.";
    } else {
        echo "Failed to track money.";
    }
}
