<?php 
require_once "./Database.php";

class OrganizationModel {

    // Create a new organization (auto-increment organizationId)
    public static function createOrganization($name): bool {
        // The organizationId is auto-incremented, so we don't need to include it in the insert statement
        $query = "INSERT INTO Organization (`organizationName`) VALUES ('$name')";
        $res = Database::run_query(query: $query);
        return $res;
    }

    // Retrieve an organization by ID
    public static function getOrganizationById($organizationId) {
        $query = "SELECT * FROM Organization WHERE organizationId = '$organizationId'";
        $res = Database::run_select_query(query: $query);
        return $res;
    }

    // Update organization information
    public static function updateOrganization($organizationId, $name) {
        $query = "UPDATE Organization 
                  SET organizationName = '$name'
                  WHERE organizationId = '$organizationId'";
        $res = Database::run_query(query: $query);
        return $res;
    }

    // Delete an organization
    public static function deleteOrganization($organizationId) {
        $query = "DELETE FROM Organization WHERE organizationId = '$organizationId'";
        $res = Database::run_query(query: $query);
        return $res;
    }

    // Retrieve all organizations
    public static function getAllOrganizations() {
        $query = "SELECT * FROM Organization";
        $res = Database::run_select_query(query: $query);
        return $res;
    }

    // Retrieve donors associated with a specific organization
    public static function getDonorsByOrganizationId($organizationId) {
        $query = "SELECT Donor.* FROM Donor 
                  JOIN OrganizationDonor ON Donor.donorId = OrganizationDonor.donorId 
                  WHERE OrganizationDonor.organizationId = '$organizationId'";
        $res = Database::run_select_query(query: $query);
        return $res;
    }
    
}
