<?php
$server = $_SERVER['DOCUMENT_ROOT'];
require_once $server . "\Database.php";

class donarLogFile {

    // CREATE DONATION LOG ENTRY
    public static function createLog($userId, $organizationId, $donationItemId, $action, $previousState = null, $currentState = null) {
        $prevState = $previousState ? "'" . mysqli_real_escape_string(Database::get_connection(), $previousState) . "'" : "NULL";
        $currState = $currentState ? "'" . mysqli_real_escape_string(Database::get_connection(), $currentState) . "'" : "NULL";
        $query = "INSERT INTO DonationLog (user_id, organization_id, donation_item_id, action, previous_state, current_state) 
                  VALUES ('$userId', '$organizationId', '$donationItemId', '$action', $prevState, $currState)";
        return Database::run_query($query);
    }

    // GET LOG BY ID
    public static function getLogById($logId) {
        $query = "SELECT * FROM DonationLog WHERE log_id = $logId";
        $result = Database::run_select_query($query);

        if ($result === false) {
            return null;
        }

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row; // Return the raw data as an associative array
        } else {
            return null;
        }
    }

    // GET LOGS FOR A USER
    public static function getLogsByUserId($userId) {
        $query = "SELECT * FROM DonationLog WHERE user_id = $userId ORDER BY timestamp DESC";
        $result = Database::run_select_query($query);

        if ($result === false) {
            return [];
        }

        $logs = [];
        while ($row = $result->fetch_assoc()) {
            $logs[] = $row;
        }

        return $logs;
    }

    // DELETE A SPECIFIC LOG (OPTIONAL)
    public static function deleteLogById($logId) {
        $query = "DELETE FROM DonationLog WHERE log_id = $logId";
        return Database::run_query($query);
    }

    // UNDO DONATION ACTION
    public static function undoAction($logId) {
        $log = self::getLogById($logId);

        if ($log && $log['previous_state']) {
            $prevState = json_decode($log['previous_state'], true);
            if ($prevState) {
                // Restore the donation to its previous state
                // Example: Update the DonationItem table with the previous state
                $query = "UPDATE DonationItem SET 
                          description = '" . mysqli_real_escape_string(Database::get_connection(), $prevState['description']) . "', 
                          date_donated = '" . $prevState['date_donated'] . "' 
                          WHERE donation_item_id = " . intval($prevState['donation_item_id']);
                return Database::run_query($query);
            }
        }

        return false;
    }

    // REDO DONATION ACTION
    public static function redoAction($logId) {
        $log = self::getLogById($logId);

        if ($log && $log['current_state']) {
            $currState = json_decode($log['current_state'], true);
            if ($currState) {
                // Restore the donation to its current state
                // Example: Update the DonationItem table with the current state
                $query = "UPDATE DonationItem SET 
                          description = '" . mysqli_real_escape_string(Database::get_connection(), $currState['description']) . "', 
                          date_donated = '" . $currState['date_donated'] . "' 
                          WHERE donation_item_id = " . intval($currState['donation_item_id']);
                return Database::run_query($query);
            }
        }

        return false;
    }
}

// $logId = 2; 

// // Call the function
// $result = donarLogFile::getLogsByUserId($logId);

// // Print the result
// if ($result) {
//     echo "Log Details:\n";
//     echo print_r($result, true); // Print associative array as a string
// } else {
//     echo "No log found with ID: $logId";
// }