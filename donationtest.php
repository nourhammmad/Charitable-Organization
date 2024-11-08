<?php
require_once "./DonationModel.php";
require_once "./Database.php";
require_once "./db-populate.php";
try {
    $db = new Database();
    Populate::populate();
} catch (Exception $e) {
    echo "Error initializing Database: " . $e->getMessage();
    exit;
}

// Test the createDonation method (for all donation types)
function testCreateDonation() {
    // Set up donation management ID (assumed to exist in your database)
    $donationManagementId = 1;

    // Test Money Donation
    $resultMoney = DonationModel::createDonation(1, $donationManagementId, 1000.00, 'USD');
    if ($resultMoney) {
        echo "Money donation created successfully.\n";
    } else {
        echo "Failed to create money donation.\n";
    }

    // Test Books Donation
    $resultBooks = DonationModel::createDonation(2, $donationManagementId, null, null, 'The Great Gatsby', 'F. Scott Fitzgerald', 1925, 10);
    if ($resultBooks) {
        echo "Books donation created successfully.\n";
    } else {
        echo "Failed to create books donation.\n";
    }

    // Test Clothes Donation
    $resultClothes = DonationModel::createDonation(3, $donationManagementId, null, null, null, null, null, 20, 'Winter Jacket', 'L', 'Red');
    if ($resultClothes) {
        echo "Clothes donation created successfully.\n";
    } else {
        echo "Failed to create clothes donation.\n";
    }
}

// Test the getDonationsByType method
function testGetDonationsByType() {
    // Test if Money donations are retrieved
    $moneyDonations = DonationModel::getDonationsByType(1);
    if (!empty($moneyDonations)) {
        echo "Money donations retrieved successfully.\n";
    } else {
        echo "No money donations found.\n";
    }

    // Test if Books donations are retrieved
    $booksDonations = DonationModel::getDonationsByType(2);
    if (!empty($booksDonations)) {
        echo "Books donations retrieved successfully.\n";
    } else {
        echo "No books donations found.\n";
    }

    // Test if Clothes donations are retrieved
    $clothesDonations = DonationModel::getDonationsByType(3);
    if (!empty($clothesDonations)) {
        echo "Clothes donations retrieved successfully.\n";
    } else {
        echo "No clothes donations found.\n";
    }
}

// Test the getDonationsByManagementId method
function testGetDonationsByManagementId() {
    $donationManagementId = 1;
    $donations = DonationModel::getDonationsByManagementId($donationManagementId);
    if (!empty($donations)) {
        echo "Donations by management ID retrieved successfully.\n";
    } else {
        echo "No donations found for this management ID.\n";
    }
}

// Test the updateDonation method
function testUpdateDonation() {
    // Test updating a money donation amount
    $donationItemId = 1;
    $updatedAmount = 1500.00;
    $result = DonationModel::updateDonation($donationItemId, $updatedAmount);
    if ($result) {
        echo "Donation updated successfully.\n";
    } else {
        echo "Failed to update donation.\n";
    }
}

// Test the deleteDonation method
function testDeleteDonation() {
    // Test deleting a donation by its ID
    $donationItemId = 1;
    $result = DonationModel::deleteDonation($donationItemId);
    if ($result) {
        echo "Donation deleted successfully.\n";
    } else {
        echo "Failed to delete donation.\n";
    }
}

// Run tests
echo "Testing createDonation...\n";
testCreateDonation();
echo "\nTesting getDonationsByType...\n";
testGetDonationsByType();
echo "\nTesting getDonationsByManagementId...\n";
testGetDonationsByManagementId();
echo "\nTesting updateDonation...\n";
testUpdateDonation();
echo "\nTesting deleteDonation...\n";
testDeleteDonation();
?>
