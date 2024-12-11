<?php
$server=$_SERVER['DOCUMENT_ROOT'];
require_once $_SERVER['DOCUMENT_ROOT']."\Database.php";

class DonationModel {
    private static function getLastInsertedDonationItemId() {
        $query = "SELECT donation_type_id FROM DonationItem ORDER BY donation_type_id DESC LIMIT 1;";
        $result = Database::run_select_query(query: $query);
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            print($row['donation_type_id']);
            return $row['donation_type_id'];
        }
    
        return null;
    }

    private static function insertDonationItem($donationManagementId, $donationTypeId, $descriptionn, $donorId): bool {
        if (Database::get_connection()) {
            $descriptionn = mysqli_real_escape_string(Database::get_connection(), $descriptionn);

            $queryDonationItem = "INSERT INTO DonationItem (donation_management_id, donation_type_id, description, date_donated)
                                VALUES ('$donationManagementId', '$donationTypeId', '$descriptionn', NOW())";
            $result = Database::run_query(query: $queryDonationItem);
        
            return $result;
        }
        else{
            echo "no connection";
            return false;
        }

    }
    public static function getDonationDescription(){
        $query="SELECT description FROM DonationItem ORDER BY date_donated DESC LIMIT 1";
        $result= Database::run_select_query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['description'];
        } else {
            return null;
        }
    }
    

    // Function for money donations
    public static function createMoneyDonation($donationManagementId,$donationitemId ,$amount, $currency = 'USD', $paymentMethod, $paymentDetails): bool {
        $description = "Cash donation of $amount $currency";
        
        self::insertDonationItem($donationManagementId, 1, $description,$paymentDetails['donor_id']);
        $donationitem= Database::get_last_inserted_id();
        $queryMoney = "INSERT INTO Money (donation_type_id,donation_management_id, amount, currency, date_donated) 
                       VALUES ($donationitemId,$donationManagementId, '$amount', '$currency', NOW())";
        $result = Database::run_query(query: $queryMoney);

        if (!$result) {
            return false;
        }


        $moneyId = Database::get_last_inserted_id();

        $queryPayment = "INSERT INTO Payments (donor_id, money_id, amount, payment_method) 
                         VALUES ('{$paymentDetails['donor_id']}', '$moneyId', '$amount', '$paymentMethod')";
        $paymentResult = Database::run_query(query: $queryPayment);
        donarLogFile::createLog(
            donorId: $paymentDetails['donor_id'],
            organizationId: 1,
            donationItemId:$donationitem,
            donation_type:1,
            previousState:NULL,
            currentState:'CREATE',
            donationId: $moneyId,
        );
        if (!$paymentResult) {
            return false;
        }
        switch ($paymentMethod) {
            case 'cash':

                $transactionId = $paymentDetails['transaction_number'];
                $queryCash = "INSERT INTO Cash (payment_id, transaction_id) 
                              VALUES ((SELECT payment_id FROM Payments WHERE money_id = '$moneyId'), '$transactionId')";
                return Database::run_query(query: $queryCash);
            case 'visa':
                $transactionNumber = $paymentDetails['transaction_number'];
                $cardNumber = $paymentDetails['cardNumber'];
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



    // Function for book donations
    public static function createBookDonation($donationTypeId=2,$donationManagementId=1, $bookTitle, $author, $publicationYear, $quantity,$donarID): bool { 
        $description = "$quantity copies of '$bookTitle' by $author";
        self::insertDonationItem($donationManagementId, 2, $description,$donarID);  
        $donationitem= Database::get_last_inserted_id();
    
        $queryBooks = "INSERT INTO Books (donation_type_id,donation_management_id, book_title, author, publication_year, quantity, date_donated) 
                       VALUES ('$donationTypeId','$donationManagementId', '$bookTitle', '$author', '$publicationYear', '$quantity', NOW())";
        Database::run_query(query: $queryBooks);
        donarLogFile::createLog(
            donorId: $donarID,
            organizationId: 1,
            donationItemId:$donationitem,
            donation_type:$donationTypeId,
            previousState:NULL,
            currentState:'CREATE',
            donationId: Database::get_last_inserted_id(),
            // action: "Create",
        );
        return true;

    }

    // Function for clothes donations
    public static function createClothesDonation($donationTypeId=3,$donationManagementId=1, $clothesType, $size, $color, $quantity,$donarID): bool {
        $description = "$quantity $color $size $clothesType";
        self::insertDonationItem($donationManagementId, 3, $description,$donarID);
        $donationitem= Database::get_last_inserted_id();
        $queryClothes = "INSERT INTO Clothes (donation_type_id,donation_management_id, clothes_type, size, color, quantity, date_donated) 
                         VALUES (3,'$donationManagementId', '$clothesType', '$size', '$color', '$quantity', NOW())";
         Database::run_query(query: $queryClothes);
         donarLogFile::createLog(
            donorId: $donarID,
            organizationId: 1,
            donationItemId:$donationitem,
            donation_type:3,
            previousState:NULL,
            currentState:'CREATE',
            donationId: Database::get_last_inserted_id(),
            // action: "Create",
        );
        return true;

    }

    //get book by id 
    public static function getBookInfoById($bookId) {
        $query = "SELECT book_id, donation_type_id,donation_management_id, book_title,author, publication_year,quantity,date_donated FROM Books WHERE book_id = '$bookId'";
        
        $result = Database::run_select_query($query);
        
        if ($result && $row = $result->fetch_assoc()) {
            return $row;
        }

        return null;
    }

    //get clothes by id 
    public static function getClothesInfoById($clothesId) {
        $query = "SELECT 
                      clothes_id,
                      donation_type_id,
                      donation_management_id,
                      clothes_type,
                      size,
                      color,
                      quantity,
                      date_donated
                  FROM Clothes 
                  WHERE clothes_id = '$clothesId'";
        $result = Database::run_select_query($query);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc(); 
        }
        return null; // No clothes found
    }

    //get money by id
    public static function getMoneyInfoById($moneyId) {
        $query = "SELECT 
                      money_id,
                      donation_type_id,
                      donation_management_id,
                      amount,
                      currency,
                      date_donated
                  FROM Money 
                  WHERE money_id = '$moneyId'";
        $result = Database::run_select_query($query);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc(); // Returns associative array of money donation info
        }
        return null; // No record found
    }

    //get trans number  by money id
    public static function getPaymentIdByMoneyId($moneyId) {

        $query = "SELECT payment_method FROM Payments WHERE money_id = '$moneyId'";
        $result = Database::run_select_query($query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['payment_method']; 
        }
        return null;
    }
    //get cash by payment id 
    public static function getTransactionIdByPaymentId($paymentId) {
        $query = "SELECT transaction_id FROM Cash WHERE payment_id = '$paymentId'";
        
        $result = Database::run_select_query($query);
        
        // Check if a result is returned
        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch the row
            $row = mysqli_fetch_assoc($result);
            return $row['transaction_id']; // Return the transaction_id
        }
        
        // Return null if no matching record is found
        return null;
    }

    //delete doantion from table 
    public static function deleteFromTableByDonationItemId($tableName, $donationItemId,$itemId) {
        $allowedTables = ['Books', 'Clothes']; 
        if (!in_array($tableName, $allowedTables)) {
            throw new InvalidArgumentException("Invalid table name: $tableName");
        }
     
        if($tableName =='Clothes'){
            $query = "DELETE FROM $tableName WHERE clothes_id = '$donationItemId'";
            Database::run_query($query);
        }
        else if ($tableName =='Books'){
            $query = "DELETE FROM $tableName WHERE book_id = '$donationItemId'";
            Database::run_query($query);
        }
        return self:: deleteDonationitem($itemId);
    }
    public static function deleteDonationitem($itemId){
        $query = "DELETE FROM DonationItem  WHERE donation_item_id = '$itemId'";
        return Database::run_query($query);
    }

    //get desc by donation item id
    public static function getDescriptionByitemId($itemId){
        $query = "SELECT description FROM DonationItem WHERE donation_item_id = '$itemId' ";
        $result = Database::run_select_query($query);
        if ($row = $result->fetch_assoc()) {
            return $row['description'];
        }
        return false;
        
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