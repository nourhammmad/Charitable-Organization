<?php
$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server."\models\OrganizationModel.php";
require_once $server."\models\EventModel.php";
require_once $server."\models\TaskModel.php";
require_once $server."\controllers\DonationManagement.php";

require_once $server."\controllers\FamilyShelterController.php";
require_once $server."\controllers\EducationalCenterController.php";
require_once $server."\controllers\FoodBankController.php";
require_once $server."\controllers\TaskManagementController.php";
require_once $server."\Services\CommunicationFacade.php";
 
    
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
            case 'createTask':
                handleCreateTask();
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
               
            // case 'sendAll':
            //     SendNotification();
            //     break;   


    
            default:
                echo "Invalid action.";
                break;
        }
    }

    // function SendNotification() {
    //     $result = CommunicationFacade::Sendall( $_POST['mail'], 
    //        $_POST['subject'] ,
    //        $_POST['body']);
    // }
    
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
        $name = $_POST['name'] ?? null; 
        $date = $_POST['date'] ?? null;
        $address = $_POST['address'] ?? null;
        $capacity = $_POST['capacity'] ?? null;
        $tickets = $_POST['tickets'] ?? null;
      //  $typeid = $_POST['typeid'] ?? null;
        $service = $_POST['service'] ?? null;
        $signLangInterpret = isset($_POST['signLang']) ? true : false;
        $wheelchair = isset($_POST['wheelchair']) ? true : false;
    
        // Validate required fields
        if (!$date || !$address || !$capacity || !$tickets ||  !$service) {
            echo "Missing required fields: date, address, capacity, tickets, and service are mandatory.";
            return;
        }
    
        // Determine the service type
       
        $familyShelter = ($service === 'familyShelter');
        $educationalCenter = ($service === 'educationalCenter');
        $foodBank = ($service === 'foodBank');
        //public static function createFamilyShelterEvent($eventName, $date, $EventAttendanceCapacity, $tickets, $signLangInterpret, $wheelchair) {
    
        // Call the method to create the event, passing in the necessary parameters
        if($service === 'familyShelter'){
            //echo"yatara ana da5alt hena ?  ";
           $isEventCreated = FamilyShelterController::createFamilyShelterEvent(
             $name,
             $date,
             $capacity,
             $capacity,
             $tickets,
             $signLangInterpret,
             $wheelchair
            );
            if ($isEventCreated) {
              echo "$service Event created successfully.";
              } else {
              echo "Failed to create event. Please try again.";
              }
        }elseif($service === 'educationalCenter'){
             $isEventCreated = EducationalCenterController::createEducationalCenterEvent(
             $name,
             $date,
             $capacity,
             $capacity,
             $tickets,
             $signLangInterpret,
             $wheelchair
             );
            if ($isEventCreated) {
             echo "$service Event created successfully.";
             } else {
             echo "Failed to create event. Please try again.";
             }
    
        }elseif($service === 'foodBank'){
            $isEventCreated = FoodBankController::createFoodBankEvent(
                $name,
                $date,
                $capacity,
                $capacity,
                $tickets,
                $signLangInterpret,
                $wheelchair
                );
               if ($isEventCreated) {
                echo "$service Event created successfully.";
                } else {
                echo "Failed to create event. Please try again.";
                }
    
        }
    
    
    
    
    
         
    
    }
    function handleCreateTask() {
        $name = $_POST['name'] ?? null;
        $description = $_POST['description'] ?? null;
        $requiredSkill = $_POST['requiredSkill'] ?? null;
        $timeSlot = $_POST['timeSlot'] ?? null;
        $location = $_POST['location'] ?? null;
    
        // Validate required fields
        if (!$name || !$description || !$requiredSkill || !$timeSlot || !$location) {
            echo "Missing required fields: name, description, requiredSkill, timeSlot, and location are mandatory.";
            return;
        }
    
        // Call the createTask method in TaskManagementController
        $taskCreationMessage = TaskManagementController::createTask($name, $description, $requiredSkill, $timeSlot, $location);
    
        // Echo the response message from createTask
        echo $taskCreationMessage;
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