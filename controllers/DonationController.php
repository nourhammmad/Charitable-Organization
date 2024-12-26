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
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'view_history') {
    header('Content-Type: application/json'); 
    $donorId = $_POST['donorId']; 

    try {
        $donations = donarLogFile::getLogsByUserId($donorId);
        if ($donations) {
            $donationsArray = array_map(function ($donation) {
                $donationItemId = $donation->getLogitemId();
                $description = '';
                if ($donationItemId) {
                    $description = DonationModel::getDescriptionByitemId($donationItemId);
                }
                if (!$description) {
                    error_log("No description found for donation_item_id: $donationItemId");
                }
                $donationArray = $donation->toArray();
                $donationArray['description'] = $description;
                return $donationArray;
            }, $donations);
    
            // Return the result as JSON
            echo json_encode(['success' => true, 'donations' => $donationsArray]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No donations found.']);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage(),
            'error' => $e->getMessage()
        ]);
    }
    exit;
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
    header('Content-Type: application/json');  // Set the content type to JSON

    $donorId = $_POST['donorId'] ?? null;  // Get donorId from POST data

    try {
        if ($donorId) {
            // Assuming getNotificationsForDonor is a function that retrieves notifications for the given donor ID
            $notifications = getNotificationsForDonor($donorId);

            // Check if notifications were found
            if ($notifications) {
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
    echo "yarab ab2a hena";
    RegisterUserTypeModel::getNotifications($donorid);
   }