<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/Services/BooksDonationFactory.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/RedoDonationCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/UndoDonationCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/ActionCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/ViewHistoryCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/ViewNotificationCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/FeesDonationFactory.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/ClothesDonationFactory.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/GetOrganizationsCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/GetDonorsCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/CreateEventCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/CreateTaskCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/TrackBooksCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/TrackClothesCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/TrackMoneyCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/SendNotificationCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/CreateResourceCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/AddTravelPlanCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/AddBeneficiaryCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/ViewTravelPlansCommand.php";


class CommandHandler {
    public static function handleRequest($action, $donorId=null, $logId = null, $donationType=null, $donationData=null) {
        $command = null;

        switch ($action) {
            case 'view_history':
            case 'view_history_clothes':
            case 'view_history_books':
            case 'view_history_money':
                $command = new ViewHistoryCommand($donorId, $action);
                break;
            case 'undo':
                $command = new UndoDonationCommand($donorId, $logId);
                break;
            case 'redo':
                $command = new RedoDonationCommand($donorId, $logId);
                break;
            case 'view_notifications':
                $command = new ViewNotificationsCommand($donorId);
                break;
            case 'add_donation':  // Example of a command for donation
                $command = new AddDonationCommand($donorId, $donationType, $donationData);  // Customize as per your needs
                break;
            case 'getOrganizations':
                $command = new GetOrganizationsCommand();
                break;
            case 'getDonors':
                $command = new GetDonorsCommand();
                break;
            case 'createEvent':
                $command = new CreateEventCommand();
                break;
            case 'createTask':
                $command = new CreateTaskCommand();
                break;
            case 'trackBooks':
                $command = new TrackBooksCommand();
                break;
            case 'trackClothes':
                $command = new TrackClothesCommand();
                break;
            case 'trackMoney':
                $command = new TrackMoneyCommand();
                break;
            case 'sendAll':
                $command = new SendNotificationCommand();
                break;
            case 'getResources':
                echo json_encode(resource::getAllResources());
                return;
            case 'createResource':
                $command = new CreateResourceCommand();
                break;
            case 'addPlan':
                $command = new AddTravelPlanCommand();
                break;
            case 'Executeplan':
                $command = new ExecuteTravelPlanCommand();
                break;
            case 'viewtravelplans':
                $command = new ViewTravelPlansCommand();
                break;
            case 'addBeneficiary':
                $command = new AddBeneficiaryCommand();
                break;
            case 'getBeneficiary':
                echo json_encode(Beneficiary::getBeneficiaries());
                return;
            case 'logout':
                session_start();
                session_unset();
                session_destroy();
                header("Location: ../index.php");
                exit();
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action.']);
                return;
        }

        if ($command) {
            $command->execute();
        }
    }
}

