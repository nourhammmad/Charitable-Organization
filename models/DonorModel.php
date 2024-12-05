<?php

$server = $_SERVER['DOCUMENT_ROOT'];
require_once $server."\Database.php";
require_once $server."\Services\Donor.php";
require_once $server."\models\donarLogFile.php";

class DonarModel {

        // GET LAST INSERTED DONOR ID
        public static function getLastInsertDonorId() {
            $query = "SELECT id FROM Donor ORDER BY id DESC LIMIT 1;";
            $res = Database::run_select_query($query);
            if ($res && $res->num_rows > 0) {
                $row = $res->fetch_assoc();
                return $row['id'];
            }
            return null;
        }
    
     // GET DONOR BY ID
     public static function getDonorById($donorId) {
        $query = "SELECT * FROM Donor WHERE id = $donorId";
        $result = Database::run_select_query($query);

        if ($result === false) {
            return null;
        }

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Donor(
                $row['id'],
                $row['registered_user_id'],
                $row['organization_id'],
                $row['donation_details']
            );
        }

        return null;
    }

    // GET DONOR BY REGISTERED USER ID
    public static function getDonorByRegisteredId($regdonorId) {
        $query = "SELECT * FROM Donor WHERE registered_user_id = $regdonorId";
        $result = Database::run_select_query($query);

        if ($result === false) {
            return null;
        }

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Donor(
                $row['id'],
                $row['registered_user_id'],
                $row['organization_id'],
                $row['donation_details']
            );
        }

        return null;
    }

    // CREATE DONOR
    public static function createDonor($registeredUserId, $organizationId, $donationDetails = null) {
        $donationDetails = $donationDetails ? "'$donationDetails'" : "NULL";
        $query = "INSERT INTO Donor (registered_user_id, organization_id, donation_details) VALUES ('$registeredUserId', '$organizationId', $donationDetails)";
        $result = Database::run_query($query);
        return $result;
        
    }

    // UPDATE DONATION DETAILS
    // public static function updateDonationDetails($donorId, $donationDetails) {
    //     $donor = self::getDonorById($donorId);
    //     if ($donor) {
    //         $previousState = json_encode(['donationDetails' => $donor->getDonationDetails()]);
    //         $query = "UPDATE Donor SET donation_details = '$donationDetails' WHERE id = '$donorId'";
    //         $result = Database::run_query($query);

    //         if ($result) {
    //             DonationLogModel::createLog(
    //                 userId: $donor->getRegisteredUserId(),
    //                 organizationId: $donor->getOrganizationId(),
    //                 donationItemId: $donorId,
    //                 action: "Update",
    //                 previousState: $previousState,
    //                 currentState: json_encode(['donationDetails' => $donationDetails])
    //             );
    //         }

    //         return $result;
    //     }

    //     return false;
    // }
    public static function addDescription($des, $id) {

        $escapedDescription = mysqli_real_escape_string(Database::get_connection(), $des);
    
        $id = intval($id);
        $query = "UPDATE Donor SET donation_details = CONCAT(COALESCE(donation_details, ''), '$escapedDescription\n') WHERE id = $id";
        $result = Database::run_query($query);
    
        if ($result) {
            return true;
        } else {
            return false;
        }
        
    }


   
}

