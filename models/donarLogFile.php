<?php
$server = $_SERVER['DOCUMENT_ROOT'];
require_once $server."/Database.php";
require_once $server."/Services/DonationLog.php";

class donarLogFile {


    // CREATE DONATION LOG ENTRY
    public static function createLog($donorId, $organizationId, $donationItemId,$donation_type, $previousState = null, $currentState = null,$donationId) {
        $query = "INSERT INTO DonationLog (donorId, organization_id, donation_item_id, donation_type_id, previous_state, current_state,donationId) 
                  VALUES ('$donorId', '$organizationId', '$donationItemId', '$donation_type', '$previousState', '$currentState','$donationId')";
        return Database::run_query($query);
    }

    // GET LOG BY ID
    public static function getLogById($logId) {
        $query = "SELECT * FROM DonationLog WHERE log_id = $logId";
        $result = Database::run_select_query($query);
    
        if ($result === false || $result->num_rows === 0) {
            return null; 
        }
    
        $row = $result->fetch_assoc();
        return new DonationLog(
            $row['log_id'],
            $row['donorId'],
            $row['organization_id'],
            $row['donation_item_id'],
            $row['donation_type_id'],
            $row['previous_state'],
            $row['current_state'],
            $row['donationId'],
        );
    }
    
    // GET LOGS FOR A USER
    public static function getLogsByUserId($userId) {
        $query = "SELECT * FROM DonationLog WHERE donorId = $userId ORDER BY timestamp DESC";
        $result = Database::run_select_query($query);
    
        if ($result === false) {
            return []; 
        }
    
        $logs = [];
        while ($row = $result->fetch_assoc()) {
            $logs[] = new DonationLog(
                $row['log_id'],
                $row['donorId'],
                $row['organization_id'],
                $row['donation_item_id'],
                $row['donation_type_id'],
                $row['previous_state'],
                $row['current_state'],
                $row['donationId'],
            );
        }
    
        return $logs;
     } 

    //get the last log enetered
    public static function getLastLogByDonorId($donorId) {
        $query = "SELECT * FROM DonationLog WHERE donorId = $donorId ORDER BY timestamp DESC LIMIT 1";
        $result = Database::run_select_query($query);

    
        if ($result === false || $result->num_rows === 0) {
            return null; 
        }
    
        $row = $result->fetch_assoc();
    

        return new DonationLog(
            $row['log_id'],
            $row['donorId'],
            $row['organization_id'],
            $row['donation_item_id'],
            $row['donation_type_id'],
            $row['previous_state'],
            $row['current_state'],
            $row['donationId'],
        );
    }
    
    //update log
    public static function undoDonation($logId) {
        // Fetch the log entry by ID
        $log = self::getLogById($logId);
     
        if ($log) {
            $oldCurrentState = $log->getLogCurrentState();
            $donationTypeId = $log->getLogtypeId();
            $donationItemId = $log->getLogitemId();
            $donationId= $log->getLogdonationId();
     
            $updateLogQuery = "UPDATE DonationLog
                               SET previous_state = '$oldCurrentState', current_state = 'DELETE',
                               donation_item_id =null
                               WHERE log_id = '$logId' AND current_state != 'DELETE'";
            $logUpdated = Database::run_query($updateLogQuery);


     
            if ($logUpdated && $donationTypeId == 2) {
                return DonationModel::deleteFromTableByDonationItemId('Books',$donationId,$donationItemId);
               
            }
            else if ($logUpdated && $donationTypeId == 3) {
                return DonationModel::deleteFromTableByDonationItemId('Clothes',$donationId,$donationItemId);
            }
            return $logUpdated; 
        }
     
        return false;
    }

    //redo 
    public static function redoDonation($donarlogId,$donorId){
        $log = self::getLogById($donarlogId);
        if($log){
            $oldCurrentState = $log->getLogCurrentState();
            $donationTypeId = $log->getLogtypeId();
            $donationItemId = $log->getLogitemId();
            $donationId= $log->getLogdonationId();
     
            $updateLogQuery = "UPDATE DonationLog
                               SET previous_state = '$oldCurrentState', current_state = 'CREATE'
                               WHERE log_id = '$donarlogId' AND current_state != 'DELETE'";
            $logUpdated = Database::run_query($updateLogQuery);

            if ($logUpdated && $donationTypeId == 2) {
                $res= DonationModel::getBookInfoById($donationId);
                return DonationModel::createBookDonation(2,1,$res['book_title'], $res['author'], $res['publication_year'],$res['quantity'],$donorId);
            }
            else if ($logUpdated && $donationTypeId == 3) {
                $res= DonationModel::getClothesInfoById($donationId);
                return DonationModel::createClothesDonation(2,1,$res['clothes_type'],$res['size'],$res['color'],$res['quantity'],$donorId);
            }
            else if ($logUpdated && $donationTypeId == 1) {
                $res= DonationModel::getMoneyInfoById($donationId);
                $paymentMethod =DonationModel::getPaymentIdByMoneyId($donationId);
                if($paymentMethod =='Cash'){
                    $paymentDetails = [
                        'donor_id' => $donorId, 
                        'transaction_number' =>  'TRANS' . uniqid() . random_int(1000, 9999), 
            
                    ];
                    return DonationModel::createMoneyDonation(1,1,$res['amount'],$res['currency'],'cash',$paymentDetails);
                }
            }
            return $logUpdated; 

        }
    }



    // DELETE A SPECIFIC LOG 
    public static function deleteLogById($logId) {
        $query = "DELETE FROM DonationLog WHERE log_id = $logId";
        return Database::run_query($query);
    }

  
}

