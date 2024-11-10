<?php
require_once "./Database.php";

class DonationModel {

    // Create a donation record (includes Money, Books, Clothes)
    private static function insertDonationItem($donationManagementId, $donationTypeId, $descriptionn): bool {
        // Remove "date_donated=NULL" and use NOW() for current timestamp
        $descriptionn = mysqli_real_escape_string(Database::get_connection(), $descriptionn);

        $queryDonationItem = "INSERT INTO DonationItem (donation_management_id, donation_type_id, description, date_donated)
                              VALUES ('$donationManagementId', '$donationTypeId', '$descriptionn', NOW())";
        $result = Database::run_query(query: $queryDonationItem);
        echo "$descriptionn";
        
        if (!$result) {
            // Log or print error
            echo "Donation Type ID: $donationTypeId";

        }
        return $result;
    }
    

    // Function for money donations
    public static function createMoneyDonation($donationManagementId, $amount, $currency = 'USD', $paymentMethod, $paymentDetails): bool {
        $description = "Cash donation of $amount $currency";
        
        // Insert the donation item for Money
        self::insertDonationItem($donationManagementId, 1, $description);

        // Insert the Money donation record
        $queryMoney = "INSERT INTO Money (donation_management_id, amount, currency, date_donated) 
                       VALUES ('$donationManagementId', '$amount', '$currency', NOW())";
        $result = Database::run_query(query: $queryMoney);

        if (!$result) {
            return false;
        }

        // Get the last inserted money_id
        $moneyId = Database::get_last_inserted_id();

        // Insert payment record into Payments table
        $queryPayment = "INSERT INTO Payments (donor_id, money_id, amount, payment_method) 
                         VALUES ('{$paymentDetails['donor_id']}', '$moneyId', '$amount', '$paymentMethod')";
        $paymentResult = Database::run_query(query: $queryPayment);

        if (!$paymentResult) {
            return false;
        }

        // Based on the payment method, insert additional details into the corresponding payment table
        switch ($paymentMethod) {
            case 'Cash':
                $transactionId = $paymentDetails['transaction_id'];
                $queryCash = "INSERT INTO Cash (payment_id, transaction_id) 
                              VALUES ((SELECT payment_id FROM Payments WHERE money_id = '$moneyId'), '$transactionId')";
                return Database::run_query(query: $queryCash);
            case 'Visa':
                $transactionNumber = $paymentDetails['transaction_number'];
                $cardNumber = $paymentDetails['card_number'];
                $queryVisa = "INSERT INTO Visa (payment_id, transaction_number, card_number) 
                              VALUES ((SELECT payment_id FROM Payments WHERE money_id = '$moneyId'), '$transactionNumber', '$cardNumber')";
                return Database::run_query(query: $queryVisa);
            case 'Instapay':
                $transactionReference = $paymentDetails['transaction_reference'];
                $accountNumber = $paymentDetails['account_number'];
                $queryInstapay = "INSERT INTO Instapay (payment_id, transaction_reference, account_number) 
                                  VALUES ((SELECT payment_id FROM Payments WHERE money_id = '$moneyId'), '$transactionReference', '$accountNumber')";
                return Database::run_query(query: $queryInstapay);
            default:
                return false;
        }
    }
//    (1, 2, '10 books including The Great Gatsby', '2024-11-01 12:00:00'),



    // Function for book donations
    public static function createBookDonation($donationTypeId=2,$donationManagementId, $bookTitle, $author, $publicationYear, $quantity): bool { 
        $description = "$quantity copies of '$bookTitle' by $author";
        self::insertDonationItem($donationManagementId, 2, $description);  // DonationType for Books is 2
    
        $queryBooks = "INSERT INTO Books (donation_type_id,donation_management_id, book_title, author, publication_year, quantity, date_donated) 
                       VALUES ('$donationTypeId','$donationManagementId', '$bookTitle', '$author', '$publicationYear', '$quantity', NOW())";
        return Database::run_query(query: $queryBooks);
    }

    // Function for clothes donations
    public static function createClothesDonation($donationTypeId=3,$donationManagementId, $clothesType, $size, $color, $quantity): bool {
        $description = "$quantity $color $size $clothesType";
        self::insertDonationItem($donationManagementId, 3, $description);

        $queryClothes = "INSERT INTO Clothes (donation_type_id,donation_management_id, clothes_type, size, color, quantity, date_donated) 
                         VALUES ('$donationTypeId','$donationManagementId', '$clothesType', '$size', '$color', '$quantity', NOW())";
        return Database::run_query(query: $queryClothes);
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