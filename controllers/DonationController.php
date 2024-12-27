<?php
require_once  $_SERVER['DOCUMENT_ROOT']."\models\RegisteredUserModel.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\Donor.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\DonationProvider.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\models\DonorModel.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\paymentMethods.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\models\donarLogFile.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\DonationLog.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\CreateState.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\UndoDonationCommand.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\RedoDonationCommand.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\RedoOnlyState.php";
require_once  $_SERVER['DOCUMENT_ROOT']."\Services\DonationLogIterator.php";






 if (isset($_POST['donorId']) && isset($_POST['donationType'])) {
    $donationType = $_POST['donationType'];
    $donorId =(int) $_POST['donorId'];
    $donationStrategy = null;

    switch ($donationType) {
        case 'book':
            $donationStrategy = new BooksDonation($_POST['bookTitle'], $_POST['author'], $_POST['publicationYear'], $_POST['quantity']);
            break;
        case 'clothes':
            $donationStrategy = new ClothesDonation($_POST['type'],$_POST['size'],$_POST['color'],$_POST['quantity']);
            break;
        case 'money':
            if($_POST['paymentType']=='cash')
             $donationStrategy = new FeesDonation($_POST['amount'],new cash($_POST['amount'],$_POST['currency']));

            else if($_POST['paymentType']=='visa'){
             $donationStrategy = new FeesDonation($_POST['amount'],new visa($_POST['amount'],$_POST['cardNumber'],$_POST['currency']));
            }
            else if($_POST['paymentType']=='stripe'){
                $donationStrategy = new FeesDonation(
                    $_POST['amount'], 
                    new StripeAdapter($_POST['amount'], $_POST['currency'], $_POST['cardNumber'])
                );
                break;
        
            }

            // else if($_POST['paymentType']='instapay')
            //  $donationStrategy = new FeesDonation($_POST['amount'],new cash($_POST['amount'],$_POST['currency']));
            break;
        default:
            echo "Invalid donation type.";
            exit;
    }
    if ($donationStrategy) {
        $donor = DonarModel::getDonorById($donorId);

        if($donor){
            $donor->setDonationStrategy($donationStrategy);

            if ($donor->donate($donorId)) {
                $donarLog= donarLogFile::getLastLogByDonorId($donorId);
                if($donationType=='money'){
                   $donarLog->setDonationState(new RedoOnlyState());
                }
               else{ 
                    $donarLog->setDonationState(new CreateState());
                }

                echo ucfirst($donationType) . " donation successful!";
            } 
            else {
                echo "Failed to donate " . $donationType . ".";
            }
        }
        else{
            echo "coudnot create donor";
        }
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
            $iterator = new DonationLogIterator($donations);
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
//echo "bara 5ales";
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'view_notifications') {
   // header('Content-Type: application/json');  // Set the content type to JSON

    $donorId = $_POST['userId'] ?? null;  // Get donorId from POST data


    try {
        if ($donorId) {
            // Assuming getNotificationsForDonor is a function that retrieves notifications for the given donor ID
            $notifications = getNotificationsForDonor($donorId);
            //print($notifications);
            // Check if notifications were found
            if ($notifications) {
                //print('k');
                echo json_encode([
                    'success' => true,
                    'notifications' => $notifications  // Return notifications data as part of the response
                ]);
            } else {
                // No notifications found for the donor
                echo json_encode([
                    'success' => false,
                    'message' => 'No notifications found.'
                ]);
            }
        } else {
            // If donorId is missing from the request
            echo json_encode([
                'success' => false,
                'message' => 'Donor ID is missing.'
            ]);
        }
    } catch (Exception $e) {
        // Handle any errors that occur during the process
        echo json_encode([
            'success' => false,
            'message' => 'An error occurred while fetching notifications.',
            'error' => $e->getMessage()  // Include the exception message for debugging
        ]);
    }

    exit;
}


// else if ($_POST['action'] === 'mark_as_read') {
//     $notificationId = $_POST['notificationId'] ?? null;
//     if ($notificationId) {
//         markNotificationAsRead($notificationId); // Implement this function to update the notification status
//         echo json_encode(['success' => true]);
//     } else {
//         echo json_encode(['success' => false, 'message' => 'Notification ID is missing.']);
//     }
// }

    


else {
    echo "Donor ID or Donation Type missing!";
}

function getNotificationsForDonor($donorid){
   // echo "yarab ab2a hena";
    return RegisterUserTypeModel::getNotifications($donorid);
   }