<?php

require_once "F:/senior 2/Design Patterns/project/Charitable-Organization/Database.php";
require_once "F:/senior 2/Design Patterns/project/Charitable-Organization/Services/Donor.php";

//to be removed
require_once "F:/senior 2/Design Patterns/project/Charitable-Organization/db-populate.php";

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
            echo "Error: Failed to execute the query.";
            return null;
        }

        if ($result->num_rows > 0) {
            echo "Success query \n";
            $row = $result->fetch_assoc();
            return new Donor(
                $row['id'],
                $row['registered_user_id'],
                $row['organization_id'],
                $row['donation_details']
            );
        } else {
            echo "No donor found with the given ID.";
            return null; 
        }
}

public static function addDescription($des, $id) {

    $escapedDescription = mysqli_real_escape_string(Database::get_connection(), $des);

    $id = intval($id);
    $query = "UPDATE Donor SET donation_details = CONCAT(COALESCE(donation_details, ''), '$escapedDescription\n') WHERE id = $id";
    $result = Database::run_query($query);

    if ($result) {
        echo "Description added successfully";
        return true;
    } else {
        echo "Failed to add description";
        return false;
    }
    
}




}

// try {
//     $db =  Database::getInstance();
//     Populate::populate();
// } catch (Exception $e) {
//     echo "Error initializing Database: " . $e->getMessage();
//     exit;
// }
// $obj=DonarModel::createDonor(1,1);
// $res=DonarModel::getDonorById(1);
// echo $res ? "Money donation created successfully.\n" : "Money donation creation failed.\n";
