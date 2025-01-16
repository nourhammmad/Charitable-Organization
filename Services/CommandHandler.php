<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/Services/BooksDonationFactory.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/RedoDonationCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/UndoDonationCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/ActionCommand.php";

require_once $_SERVER['DOCUMENT_ROOT']."/Services/ViewHistoryCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/FeesDonationFactory.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/ClothesDonationFactory.php";

class CommandHandler {
    public static function handleRequest($action, $donorId, $logId = null, $donationType=null, $donationData=null) {
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
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action.']);
                return;
        }

        if ($command) {
            $command->execute();
        }
    }
}

