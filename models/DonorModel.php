<?php

require_once "./Database.php";
require_once "./Services/Donor.php";


class DonarModel{

    //CREATE DONOR
    public static function createDonor($registeredUserId, $organizationId, $donationDetails = null) {
        $donationDetails = $donationDetails ? "'$donationDetails'" : "NULL";
        $query = "INSERT INTO Donor (`registered_user_id`, `organization_id`, `donation_details`) VALUES ('$registeredUserId', '$organizationId', $donationDetails)";
        return Database::run_query($query);
    }

    public static function updateDonationDetails($donorId, $donationDetails) {
        $query = "UPDATE Donor SET `donation_details` = '$donationDetails' WHERE `id` = '$donorId'";
        return Database::run_query($query);
    }

    public static function getLastInsertDonorId() {
        $query = "SELECT `id` FROM Donor ORDER BY `id` DESC LIMIT 1;";
        $res = Database::run_select_query(query: $query);
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            return $row['id'];  
        }
        return null;  
    }

   public static function getDonorById($donorId) {

        $query = "SELECT * FROM Donor WHERE `id` = $donorId";
        $result = Database::run_select_query($query);

        if ($result === false) {
           // echo "Error: Failed to execute the query.";
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
        } else {
            //echo "No donor found with the given ID.";
            return null; 
        }
    }
    public static function getDonorByRegisteredId($regdonorId) {

        $query = "SELECT * FROM Donor WHERE `registered_user_id` = $regdonorId";
        $result = Database::run_select_query($query);

        if ($result === false) {
           // echo "Error: Failed to execute the query.";
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
        } else {
           // echo "No donor found with the given ID.";
            return null; 
        }
    }

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

