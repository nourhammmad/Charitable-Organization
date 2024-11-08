<?php
require_once "Database.php";

class Populate {
    public static function populate() {
        Database::run_queries(
         [
            "SET FOREIGN_KEY_CHECKS = 0;",
            "DROP TABLE IF EXISTS Users, Payments, Donations, RegisteredUserType, Events, Tasks, DonationType, Donor, Organization, OrganizationDonor, DonationItem, DonationManagement, Clothes, Books, Money, IPayment, Cash, Visa, Instapay;",
            "SET FOREIGN_KEY_CHECKS = 1;",

            // Create Users Table
           " CREATE TABLE Users (
                `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `types` ENUM('Guest', 'RegisteredUserType'),
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

           " CREATE TABLE RegisteredUserType (
                `id` INT NOT NULL,
                `email` VARCHAR(50) UNIQUE NOT NULL,
                `userName` VARCHAR(50) UNIQUE NOT NULL,
                `passwordHash` VARCHAR(255) NOT NULL,
                `category` ENUM('Volunteer', 'Donor'),
                PRIMARY KEY (`id`),
                FOREIGN KEY (`id`) REFERENCES Users(`id`) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            "CREATE TABLE Organization (
                `id` INT NOT NULL DEFAULT 1 PRIMARY KEY,
                `name` VARCHAR(100) NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

"INSERT INTO Organization (`name`)
VALUES ('My Charitable Organization');
"

// "
// INSERT INTO Users (`types`)
// VALUES ('Guest'),
//        ('RegisteredUserType');",
//       " INSERT INTO RegisteredUserType (`email`, `userName`, `passwordHash`, `category`, `id`)
//        VALUES ('donor@example.com', 'DonorUser', 'hashedpassword2', 'Donor', LAST_INSERT_ID());
//       "

            // // Insert into DonationType Table
            // "INSERT INTO DonationType (donationId, quantityDonated) VALUES 
            //     ('donation001', 100), 
            //     ('donation002', 50);",

            // // Insert into Donor Table
            // "INSERT INTO Donor (donorId, donationId, roleDetails, registeredUserId) VALUES
            //     ('xyz123-donor', 'donation001', 'Donor Role Description', '123e4567-e89b-12d3-a456-426614174001'),
            //     ('xyz124-donor', 'donation002', 'Another Donor Role', '123e4567-e89b-12d3-a456-426614174001');",

            // // Insert into Organization Table
            // "INSERT INTO Organization (organizationId, organizationName, registeredUserId) VALUES
            //     ('abc123-org', 'Organization 1', '123e4567-e89b-12d3-a456-426614174000');",

            // // Insert into OrganizationDonor Table
            // "INSERT INTO OrganizationDonor (organizationId, donorId) VALUES
            //     ('abc123-org', 'xyz123-donor'),
            //     ('abc123-org', 'xyz124-donor');",

            // // Insert into DonationManagement Table
            // "INSERT INTO DonationManagement (organizationId, donationTypeId) VALUES 
            //     ('abc123-org', 'donation001'),
            //     ('abc123-org', 'donation002');",

            // // Insert into DonationItem Table
            // "INSERT INTO DonationItem (donationManagementId, quantity) VALUES
            //     (1, 10),
            //     (2, 20);",

            // // Insert into Clothes Table
            // "INSERT INTO Clothes (clothesId, donationId, clothingDescription) VALUES 
            //     ('clothes123', 'donation001', 'T-shirt'),
            //     ('clothes124', 'donation002', 'Jacket');",

            // // Insert into Books Table
            // "INSERT INTO Books (bookId, donationId, bookTitle, bookAuthor) VALUES
            //     ('book123', 'donation001', 'Book Title 1', 'Author 1'),
            //     ('book124', 'donation002', 'Book Title 2', 'Author 2');",

            // // Insert into IPayment Table
            // "INSERT INTO IPayment (paymentId, paymentMethod) VALUES 
            //     ('payment123', 'Credit Card'), 
            //     ('payment124', 'PayPal');",

            // // Insert into Money Table
            // "INSERT INTO Money (moneyId, donationId, amount, paymentId) VALUES
            //     ('money123', 'donation001', 100.00, 'payment123'),
            //     ('money124', 'donation002', 50.00, 'payment124');",

            // // Insert into Cash Table
            // "INSERT INTO Cash (cashId, paymentId, cashAmount) VALUES
            //     ('cash123', 'payment123', 100.00),
            //     ('cash124', 'payment124', 50.00);",

            // // Insert into Visa Table
            // "INSERT INTO Visa (visaId, paymentId, cardNumber, expiryDate) VALUES
            //     ('visa123', 'payment123', '1234567812345678', '2025-12-31'),
            //     ('visa124', 'payment124', '9876543212345678', '2026-12-31');",

            // // Insert into Instapay Table
            // "INSERT INTO Instapay (instapayId, paymentId, username, transactionId) VALUES
            //     ('instapay123', 'payment123', 'user1', 'trans001'),
            //     ('instapay124', 'payment124', 'user2', 'trans002');"
         ],
    true);
    }
}
?>
