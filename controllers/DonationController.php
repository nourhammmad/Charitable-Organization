<?php
require_once  $_SERVER['DOCUMENT_ROOT']."\models\RegisteredUserModel.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\Donor.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\BooksDonationFactory.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\ClothesDonationFactory.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\FeesDonationFactory.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\models\DonorModel.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\paymentMethods.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\models\donarLogFile.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\DonationLog.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\CreateState.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\UndoDonationCommand.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\RedoDonationCommand.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\RedoOnlyState.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\DonationLogIterator.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\DonationLogIterable.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\DonationFactory.php";






 if (isset($_POST['donorId']) && isset($_POST['donationType'])) {
    $donationType = $_POST['donationType'];
    $donorId =(int) $_POST['donorId'];
    $donationStrategy = null;
   
     switch ($donationType) {
         case 'book':
            $donationStrategy =  BooksDonationFactory::createDonation($donationType,$donorId,null, null, null, $_POST['quantity'], $_POST['bookTitle'], $_POST['author'], $_POST['publicationYear'],null, null, null );
            break;
         case 'clothes':
            $donationStrategy =  ClothesDonationFactory::createDonation($donationType,$donorId, $_POST['type'],$_POST['size'],$_POST['color'],$_POST['quantity'], null, null, null, null, null, null);
            break;
         case 'money':
            if($_POST['paymentType']=='cash')
             $donationStrategy =  FeesDonationFactory::createDonation($_POST['paymentType'], $donorId, null, null, null, null ,null, null, null,$_POST['amount'],$_POST['currency'], null );

            else if($_POST['paymentType']=='visa'){
             $donationStrategy =  FeesDonationFactory::createDonation($_POST['paymentType'], $donorId, null, null, null, null ,null, null, null,$_POST['amount'],$_POST['currency'], $_POST['cardNumber'] );
            }
            else if($_POST['paymentType']=='stripe'){
                $donationStrategy =  FeesDonationFactory::createDonation(
                    $_POST['paymentType'], $donorId, null, null, null, null ,null, null, null,$_POST['amount'],$_POST['currency'], null 
                );
                break;
        
            }
            break;
        default:
            echo "Invalid donation type.";
            exit;
     }
   
    
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_POST['action'], 'view_history') !== false) {
    $donorId = $_POST['donorId'];
    $action = $_POST['action'];

    try {
        // Check if the action contains 'view_history' as part of its value
        if (strpos($action, 'view_history') !== false) {
            $donations = donarLogFile::getLogsByUserId($donorId);

            // Apply filtering based on the specific action type (clothes, books, money, etc.)
            $donationLogIterable = new DonationLogIterable($donations);
            $iterator =$donationLogIterable->getIterator();
            // Determine donation type based on the action
            if ($action === 'view_history_clothes') {
                $iterator->filterByType(3); // Filter for clothes
            } elseif ($action === 'view_history_books') {
                $iterator->filterByType(2); // Filter for books
            } elseif ($action === 'view_history_money') {
                $iterator->filterByType(1); // Filter for money
            } else {
                // Handle the default 'view_history' case (all donations)
                $iterator->filterByType(null); // No filter, all donations
            }

            $donationArray = [];

            foreach ($iterator as $donation) {
                // Fetch the description for each donation item
                $donationItemId = $donation->getLogitemId();
                $description = '';

                if ($donationItemId) {
                    $description = DonationModel::getDescriptionByitemId($donationItemId);
                }

                if (!$description) {
                    error_log("No description found for donation_item_id: $donationItemId");
                }

                // Convert donation to array and add description at the same level as other properties
                $donationArray[] = array_merge($donation->toArray(), ['description' => $description]);
            }

            error_log("Arrasy ba3d el for loop: " . print_r($donationArray, true));

            // Return the donations with description in the response
            echo json_encode(['success' => true, 'donations' => $donationArray]);
        } else {
            // Handle case where the action does not contain 'view_history'
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action.'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage(),
            'error' => $e->getMessage()
        ]);
    }
}

else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'undo') 
    {
        $donorId = $_POST['donorId'];
        $logId = $_POST['log_id'];

        $donor = DonarModel::getDonorById($donorId);
        $donationLog = donarLogFile::getLogById($logId);

        if ($donor &&$donationLog ) {
            if ($donationLog->getDonationState()->canUndo()) {
                $donor->setDonationCommand(new UndoDonationCommand($donationLog));
                $donor->executeCommand();
                echo json_encode(['success' => true, 'message' => 'Undo successful.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Undo not allowed in current state.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Donor not found!']);
        }
    } 
elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action']==='redo') {
        $donorId = $_POST['donorId'];
        $logId = $_POST['log_id'];

        $donor = DonarModel::getDonorById($donorId);
        $donationLog = donarLogFile::getLogById($logId);

        if ($donor &&$donationLog ) {
            if ($donationLog->getDonationState()->canRedo()) {
                $donor->setDonationCommand(new RedoDonationCommand($donationLog,$donorId));
                $donor->executeCommand();
                echo json_encode(['success' => true, 'message' => 'Redo successful.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Redo not allowed in current state.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Donor not found!']);
        }
}

else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'view_notifications') {

    $donorId = $_POST['userId'] ?? null;  // Get donorId from POST data


    try {
        if ($donorId) {
            $notifications = getNotificationsForDonor($donorId);
      
            if ($notifications) {
         
                echo json_encode([
                    'success' => true,
                    'notifications' => $notifications  
                ]);
            } else {
           
                echo json_encode([
                    'success' => false,
                    'message' => 'No notifications found.'
                ]);
            }
        } else {
         
            echo json_encode([
                'success' => false,
                'message' => 'Donor ID is missing.'
            ]);
        }
    } catch (Exception $e) {
       
        echo json_encode([
            'success' => false,
            'message' => 'An error occurred while fetching notifications.',
            'error' => $e->getMessage()  // Include the exception message for debugging
        ]);
    }

    exit;
}



    


else {
    echo "Donor ID or Donation Type missing!";
}

function getNotificationsForDonor($donorid){

    return RegisterUserTypeModel::getNotifications($donorid);
   }