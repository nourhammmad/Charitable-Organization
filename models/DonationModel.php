<?php
require_once "./Database.php";

class DonationModel {

    // Create a donation record (includes Money, Books, Clothes)
    public static function createDonation($donationTypeId, $donationManagementId, $amount = null, $currency = 'USD', $bookTitle = null, $author = null, $publicationYear = null, $quantity = null, $clothesType = null, $size = null, $color = null): bool {
        // Insert donation item
        $queryDonationItem = "INSERT INTO DonationItem (`donation_management_id`, `donation_type_id`, `description`, `date_donated`) VALUES 
                                ('$donationManagementId', '$donationTypeId', 'Donation for type $donationTypeId', NOW())";
        Database::run_query(query: $queryDonationItem);

        if ($donationTypeId == 1) {
            // Money donation
            $queryMoney = "INSERT INTO Money (`donation_type_id`, `donation_management_id`, `amount`, `currency`, `date_donated`) 
                            VALUES ('$donationTypeId', '$donationManagementId', '$amount', '$currency', NOW())";
            return Database::run_query(query: $queryMoney);
        } elseif ($donationTypeId == 2) {
            // Books donation
            $queryBooks = "INSERT INTO Books (`donation_type_id`, `donation_management_id`, `book_title`, `author`, `publication_year`, `quantity`, `date_donated`) 
                            VALUES ('$donationTypeId', '$donationManagementId', '$bookTitle', '$author', '$publicationYear', '$quantity', NOW())";
            return Database::run_query(query: $queryBooks);
        } elseif ($donationTypeId == 3) {
            // Clothes donation
            $queryClothes = "INSERT INTO Clothes (`donation_type_id`, `donation_management_id`, `clothes_type`, `size`, `color`, `quantity`, `date_donated`) 
                             VALUES ('$donationTypeId', '$donationManagementId', '$clothesType', '$size', '$color', '$quantity', NOW())";
            return Database::run_query(query: $queryClothes);
        }
        return false; // Invalid donation type
    }

    // Get all donations by type (Money, Books, Clothes)
    public static function getDonationsByType($donationTypeId) {
        $query = "SELECT * FROM DonationItem di
                  JOIN DonationTypes dt ON di.donation_type_id = dt.donation_type_id
                  WHERE di.donation_type_id = $donationTypeId";
        return Database::run_select_query(query: $query);
    }

    // Get all donations for a specific donation management
    public static function getDonationsByManagementId($donationManagementId) {
        $query = "SELECT * FROM DonationItem WHERE donation_management_id = $donationManagementId";
        return Database::run_select_query(query: $query);
    }

    // Update donation information (amount, quantity, etc.)
    public static function updateDonation($donationItemId, $amount = null, $quantity = null) {
        if ($amount !== null) {
            $queryMoney = "UPDATE Money SET amount = '$amount' WHERE donation_item_id = $donationItemId";
            Database::run_query(query: $queryMoney);
        }

        if ($quantity !== null) {
            $queryBooksClothes = "UPDATE Books SET quantity = '$quantity' WHERE donation_item_id = $donationItemId";
            Database::run_query(query: $queryBooksClothes);
            $queryClothes = "UPDATE Clothes SET quantity = '$quantity' WHERE donation_item_id = $donationItemId";
            Database::run_query(query: $queryClothes);
        }

        return true;
    }

    // Delete a donation item (either Money, Books, or Clothes)
    public static function deleteDonation($donationItemId) {
        $query = "DELETE FROM DonationItem WHERE donation_item_id = $donationItemId";
        return Database::run_query(query: $query);
    }
}
?>
