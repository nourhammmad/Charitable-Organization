<?php
$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server."\models\OrganizationModel.php";
require_once $server."\models\EventModel.php";
require_once $server."\models\TaskModel.php";
require_once $server."\models\BeneficiaryModel.php";
require_once $server."\controllers\DonationManagement.php";
require_once $server."\controllers\FamilyShelterController.php";
require_once $server."\controllers\EducationalCenterController.php";
require_once $server."\controllers\FoodBankController.php";
require_once $server."\controllers\TaskManagementController.php";
require_once $server."\Services\CommunicationFacade.php";
require_once $server."\Services\Resources.php";
require_once $server."\Services\TravelManagement.php";
require_once $server."\controllers\TravelplanController.php";



class OrganizationController{
 
    function handleRequest(){
        if (isset($_GET['action'])) {
            $action = $_GET['action']??null;

            // Collect donation data if donationType is provided

            // Ensure action and donorId are provided
            if ($action) {
                CommandHandler::handleRequest($action, null,null, null,null);
            } else {
                echo json_encode(['success' => false, 'message' => 'Action is missing.']);
            }
        }
        


        }



    function logout(){
     
        session_start();
        session_unset(); 
        session_destroy(); // Destroy the session

    // Redirect to loginView.php
    header("Location: ../index.php");
    require_once "../index.php";
    exit(); // 

        
    }

    function handleGetTravelPlans() {
        try {
            // Instantiate the TravelPlanController
            $travelController = new TravelPlanController();

            // Fetch all travel plans
            $travelPlans = $travelController->getAllPlans();
           
            // Return as JSON response
            header('Content-Type: application/json');
            echo json_encode($travelPlans);
        } catch (Exception $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
    
    function Executeplan() {
        try {
            $planId = intval($_POST['planId'] ?? 0); 
    
            if ($planId > 0) {
                // Instantiate TravelManagement
                $travelManagement = new TravelManagement();
    
                // Call the executeTravelPlan method
                $travelManagement->executeTravelPlan($planId);
            } else {
                echo "Plan ID is required to execute a travel plan.";
            }
        } catch (Exception $e) {
            echo "Error executing travel plan: " . $e->getMessage();
        }
    }

        function SendNotification() {
        $result = CommunicationFacade::Sendall( $_POST['mail'], 
           $_POST['subject'] ,
           $_POST['body'],
           $_POST['phone']);
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
        $name = $_POST['name'] ?? null; 
        $date = $_POST['date'] ?? null;
        $capacity = $_POST['capacity'] ?? null;
        $tickets = $_POST['tickets'] ?? null;
        $shelterLocation = $_POST['address'] ?? null;
        $service = $_POST['service'] ?? null;
        $signLangInterpret = isset($_POST['signLang']) ? true : false;
        $wheelchair = isset($_POST['wheelchair']) ? true : false;
    
        // Validate required fields
        if (!$date || !$shelterLocation || !$capacity || !$tickets ||  !$service) {
            echo "Missing required fields: date, address, capacity, tickets, and service are mandatory.";
            return;
        }
    

          // Fetch all addresses (optional use case)
            $allAddresses = EventModel::GetAddresses();

            // Check if the provided address is valid
            $addressExists = array_filter($allAddresses, function($addr) use ($shelterLocation) {
                return $addr['addressId'] == $shelterLocation;
            });

            if (empty($addressExists)) {
                echo "Invalid address selected.";
                return;
            }
       
        $familyShelter = ($service === 'familyShelter');
        $educationalCenter = ($service === 'educationalCenter');
        $foodBank = ($service === 'foodBank');
        //public static function createFamilyShelterEvent($eventName, $date, $EventAttendanceCapacity, $tickets, $signLangInterpret, $wheelchair) {
    
        // Call the method to create the event, passing in the necessary parameters
        if($service === 'familyShelter'){
             $isEventCreated = FamilyShelterController::createFamilyShelterEvent(
             $name,
             $date,
             $capacity,
             $capacity,
             $tickets,
             $shelterLocation,
             $signLangInterpret,
             $wheelchair
            );
            if ($isEventCreated) {
              echo "$service Event created successfully.";
              } else {
              echo "Failed to create event. Please try again.";
              }
        }elseif($service === 'educationalCenter'){
            print($shelterLocation);
             $isEventCreated = EducationalCenterController::createEducationalCenterEvent(
             $name,
             $date,
             $capacity,
             $capacity,
             $tickets,
             $shelterLocation,
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
                $tickets,
                $shelterLocation,
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
    }
    $controller = new OrganizationController();
    $controller->handleRequest();



    ?>