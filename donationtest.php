<?php
require_once "../Charitable-Organization/models/DonationModel.php";
require_once "D:/SDP/project/Charitable-Organization/Database.php";
require_once "D:/SDP/project/Charitable-Organization/db-populate.php";
try {
    $db =  Database::getInstance();
    Populate::populate();
} catch (Exception $e) {
    echo "Error initializing Database: " . $e->getMessage();
    exit;
}

class DonationModelTest {

    // Test function to create a Money Donation
    public static function testCreateMoneyDonation() {
        $donationManagementId = 1; // Example ID
        $amount = 3300;
        $currency = 'USD';
        $paymentMethod = 'Visa'; // Example payment method
        $paymentDetails = [
            'donor_id' => 1, // Example donor ID
            'transaction_number' => 'VISA67891', // Example transaction ID
            'card_number'=>'1234-5678-9876-5435',
        ];
        
        $result = DonationModel::createMoneyDonation($donationManagementId, $amount, $currency, $paymentMethod, $paymentDetails);
        
        // Assuming run_query returns true on success
        echo $result ? "Money donation created successfully.\n" : "Money donation creation failed.\n";
    }

    // Test function to create a Book Donation
    public static function testCreateBookDonation() {
        $donationManagementId = 1; // Example ID for the donation management record
        $bookTitle = 'ma3rafsh Book';
        $author = 'John Do skdjfne';
        $publicationYear = 2020;
        $quantity = 50;
        
        // Call the createBookDonation method
        $result = DonationModel::createBookDonation(2,$donationManagementId, $bookTitle, $author, $publicationYear, $quantity);
        
        // Assuming run_query returns true on success
        echo $result ? "Book donation created successfully.\n" : "Book donation creation failed.\n";
    }
    
    // Test function to create a Clothes Donation
    public static function testCreateClothesDonation() {
        $donationManagementId = 1; // Example ID for the donation management record
        $clothesType = 'T-shirt';
        $size = 'XL';
        $color = 'Reed';
        $quantity = 10;
        
        // Call the createClothesDonation method
        $result = DonationModel::createClothesDonation(3,$donationManagementId, $clothesType, $size, $color, $quantity);
        
        // Assuming run_query returns true on success
        echo $result ? "Clothes donation created successfully.\n" : "Clothes donation creation failed.\n";
    }
    
    // Test function to get donations by donation type (Money)
    public static function testGetDonationsByTypeMoney() {
        $donationTypeId = 1; // ID for Money donation type
        
        $result = DonationModel::getDonationsByType($donationTypeId);
        
        if ($result) {
            echo "Money donations retrieved successfully:\n";
            print_r($result); // Assuming result is an array or object
        } else {
            echo "No money donations found.\n";
        }
    }

    // Test function to get donations by donation management ID
    public static function testGetDonationsByManagementId() {
        $donationManagementId = 1; // Example donation management ID
        
        $result = DonationModel::getDonationsByManagementId($donationManagementId);
        
        if ($result) {
            echo "Donations for management ID $donationManagementId retrieved successfully:\n";
            print_r($result);
        } else {
            echo "No donations found for management ID $donationManagementId.\n";
        }
    }

    // Test function to update a donation (update quantity for books)
    public static function testUpdateDonation() {
        $donationItemId = 1; // Example donation item ID
        $newQuantity = 7; // New quantity to set
        
        $result = DonationModel::updateDonation($donationItemId, null, $newQuantity);
        
        echo $result ? "Donation updated successfully.\n" : "Donation update failed.\n";
    }

    // Test function to delete a donation item
    public static function testDeleteDonation() {
        $donationItemId = 1; // Example donation item ID
        
        $result = DonationModel::deleteDonation($donationItemId);
        
        echo $result ? "Donation deleted successfully.\n" : "Donation deletion failed.\n";
    }
}

// Run all the tests
DonationModelTest::testCreateMoneyDonation();
DonationModelTest::testCreateBookDonation();
DonationModelTest::testCreateClothesDonation();
DonationModelTest::testGetDonationsByTypeMoney();
DonationModelTest::testGetDonationsByManagementId();
DonationModelTest::testUpdateDonation();
DonationModelTest::testDeleteDonation();
?>