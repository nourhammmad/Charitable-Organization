<?php
require_once "./Database.php";

class DonationModel {

    // Create a new donation management entry
    public static function createDonationManagement($organizationId, $donationTypeId) {
        $query = "INSERT INTO DonationManagement (organizationId, donationTypeId) VALUES (?, ?)";
        return Database::run_query($query, [$organizationId, $donationTypeId]);
    }

    // Create a new donation item
    public static function createDonationItem($donationManagementId, $quantity) {
        $query = "INSERT INTO DonationItem (donationManagementId, quantity) VALUES (?, ?)";
        return Database::run_query($query, [$donationManagementId, $quantity]);
    }

    // Step 1: Create a new generic IPayment record
    public static function createPayment($paymentMethod) {
        $query = "INSERT INTO IPayment (paymentMethod) VALUES (?)";
        $res = Database::run_query($query, [$paymentMethod]);

        if ($res) {
            // Fetch the last inserted ID from the database
            $query = "SELECT LAST_INSERT_ID() AS lastId";
            $idResult = Database::run_select_query($query);

            // Check if the result is a mysqli_result object and fetch the associative array
            if ($idResult instanceof mysqli_result) {
                $idArray = $idResult->fetch_assoc();
                return $idArray['lastId'];
            }
        }

        return false;
    }

    // Step 2: Create a Cash Payment linked to IPayment
    public static function createCashPayment($paymentId, $cashAmount) {
        $query = "INSERT INTO Cash (paymentId, cashAmount) VALUES (?, ?)";
        return Database::run_query($query, [$paymentId, $cashAmount]);
    }

    // Step 2: Create a Visa Payment linked to IPayment
    public static function createVisaPayment($paymentId, $cardNumber, $expiryDate) {
        $query = "INSERT INTO Visa (paymentId, cardNumber, expiryDate) VALUES (?, ?, ?)";
        return Database::run_query($query, [$paymentId, $cardNumber, $expiryDate]);
    }

    // Step 2: Create an Instapay Payment linked to IPayment
    public static function createInstapayPayment($paymentId, $username, $transactionId) {
        $query = "INSERT INTO Instapay (paymentId, username, transactionId) VALUES (?, ?, ?)";
        return Database::run_query($query, [$paymentId, $username, $transactionId]);
    }

    // Step 3: Insert a Money donation with the referenced paymentId
    public static function createMoneyDonation($donationId, $amount, $paymentId) {
        $query = "INSERT INTO Money (donationId, amount, paymentId) VALUES (?, ?, ?)";
        return Database::run_query($query, [$donationId, $amount, $paymentId]);
    }

    // Retrieve donation management details by ID
    public static function getDonationManagementById($donationManagementId) {
        $query = "SELECT * FROM DonationManagement WHERE donationManagementId = ?";
        return Database::run_select_query($query, [$donationManagementId]);
    }

    // Retrieve donation item details by donationManagementId
    public static function getDonationItemByDonationManagementId($donationManagementId) {
        $query = "SELECT * FROM DonationItem WHERE donationManagementId = ?";
        return Database::run_select_query($query, [$donationManagementId]);
    }

    // Retrieve donation type details
    public static function getDonationTypeById($donationId) {
        $query = "SELECT * FROM DonationType WHERE donationId = ?";
        return Database::run_select_query($query, [$donationId]);
    }

    // Retrieve payment details (Cash, Visa, Instapay) by donationId
    public static function getPaymentByDonationId($donationId) {
        $query = "SELECT * FROM IPayment 
                  JOIN Money ON IPayment.paymentId = Money.paymentId
                  WHERE Money.donationId = ?";
        return Database::run_select_query($query, [$donationId]);
    }

    // Delete donation management entry
    public static function deleteDonationManagement($donationManagementId) {
        $query = "DELETE FROM DonationManagement WHERE donationManagementId = ?";
        return Database::run_query($query, [$donationManagementId]);
    }

    // Delete donation item
    public static function deleteDonationItem($donationItemId) {
        $query = "DELETE FROM DonationItem WHERE donationItemId = ?";
        return Database::run_query($query, [$donationItemId]);
    }
}
?>
