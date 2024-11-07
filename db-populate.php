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
            "CREATE TABLE Users (
                `id` CHAR(36) NOT NULL PRIMARY KEY,
                `types` ENUM('Guest', 'RegisteredUserType'),
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            // Create RegisteredUserType Table
            "CREATE TABLE RegisteredUserType (
                `id` CHAR(36) NOT NULL,
                `email` VARCHAR(50) UNIQUE NOT NULL,
                `userName` VARCHAR(50) UNIQUE NOT NULL,
                `passwordHash` VARCHAR(255) NOT NULL,
                `category` Enum('Org', 'Donar'),
                PRIMARY KEY (id),
                FOREIGN KEY (id) REFERENCES Users(id) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            // Create DonationType Table
            "CREATE TABLE DonationType (
                `donationId` CHAR(36) PRIMARY KEY,
                `quantityDonated` INT NOT NULL
            )DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            // Create Donor Table
            "CREATE TABLE Donor (
                `donorId` CHAR(36) PRIMARY KEY,
                `donationId` CHAR(36),
                `roleDetails` TEXT,
                `registeredUserId` CHAR(36) NOT NULL,
                FOREIGN KEY (donationId) REFERENCES DonationType(donationId) ON DELETE SET NULL,
                FOREIGN KEY (registeredUserId) REFERENCES RegisteredUserType(id) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            // Create Organization Table
            "CREATE TABLE Organization (
                `organizationId` CHAR(36) PRIMARY KEY,
                `organizationName` VARCHAR(255) NOT NULL,
                `registeredUserId` CHAR(36) NOT NULL,
                FOREIGN KEY (registeredUserId) REFERENCES RegisteredUserType(id) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            // Create OrganizationDonor Table
            "CREATE TABLE OrganizationDonor (
                `organizationId` CHAR(36),
                `donorId` CHAR(36),
                PRIMARY KEY (organizationId, donorId),
                FOREIGN KEY (organizationId) REFERENCES Organization(organizationId) ON DELETE CASCADE,
                FOREIGN KEY (donorId) REFERENCES Donor(donorId) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            // Create DonationManagement Table
            "CREATE TABLE DonationManagement (
                `donationManagementId` INT AUTO_INCREMENT PRIMARY KEY,
                `organizationId` CHAR(36) NOT NULL,
                `donationTypeId` CHAR(36) NOT NULL,
                FOREIGN KEY (`organizationId`) REFERENCES Organization(`organizationId`) ON DELETE CASCADE,
                FOREIGN KEY (`donationTypeId`) REFERENCES DonationType(`donationId`) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            // Create DonationItem Table
            "CREATE TABLE DonationItem (
                `donationItemId` INT AUTO_INCREMENT PRIMARY KEY,
                `donationManagementId` INT NOT NULL,
                `quantity` INT NOT NULL,
                FOREIGN KEY (`donationManagementId`) REFERENCES DonationManagement(`donationManagementId`) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            // Create Clothes Table
            "CREATE TABLE Clothes (
                `clothesId` CHAR(36) PRIMARY KEY,
                `donationId` CHAR(36) NOT NULL,  
                `clothingDescription` VARCHAR(255),
                FOREIGN KEY (`donationId`) REFERENCES DonationType(`donationId`) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            // Create Books Table
            "CREATE TABLE Books (
                `bookId` CHAR(36) PRIMARY KEY,
                `donationId` CHAR(36) NOT NULL, 
                `bookTitle` VARCHAR(255),
                `bookAuthor` VARCHAR(255),
                FOREIGN KEY (`donationId`) REFERENCES DonationType(`donationId`) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            // Create IPayment Table
            "CREATE TABLE IPayment (
                `paymentId` CHAR(36) PRIMARY KEY,
                `paymentMethod` VARCHAR(255) NOT NULL
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            // Create Money Table
            "CREATE TABLE Money (
                `moneyId` CHAR(36) PRIMARY KEY,
                `donationId` CHAR(36) NOT NULL,  
                `amount` DECIMAL(10, 2) NOT NULL,
                `paymentId` CHAR(36),  
                FOREIGN KEY (`donationId`) REFERENCES DonationType(`donationId`) ON DELETE CASCADE,
                FOREIGN KEY (`paymentId`) REFERENCES IPayment(`paymentId`) ON DELETE SET NULL
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            // Create Cash Table
            "CREATE TABLE Cash (
                `cashId` CHAR(36) PRIMARY KEY,
                `paymentId` CHAR(36) NOT NULL, 
                `cashAmount` DECIMAL(10, 2) NOT NULL,
                FOREIGN KEY (`paymentId`) REFERENCES IPayment(`paymentId`) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            // Create Visa Table
            "CREATE TABLE Visa (
                `visaId` CHAR(36) PRIMARY KEY,
                `paymentId` CHAR(36) NOT NULL,  
                `cardNumber` VARCHAR(16) NOT NULL,
                `expiryDate` DATE NOT NULL,
                FOREIGN KEY (`paymentId`) REFERENCES IPayment(`paymentId`) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            // Create Instapay Table
            "CREATE TABLE Instapay (
                `instapayId` CHAR(36) PRIMARY KEY,
                `paymentId` CHAR(36) NOT NULL,  
                `username` VARCHAR(255) NOT NULL,
                `transactionId` CHAR(36) NOT NULL,
                FOREIGN KEY (`paymentId`) REFERENCES IPayment(`paymentId`) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            // Insert into Users Table
            "INSERT INTO Users (id, types) VALUES 
                ('u1', 'RegisteredUserType'),
                ('u2', 'RegisteredUserType');",

            // Insert into RegisteredUserType Table
           " INSERT INTO RegisteredUserType (id, email, userName, passwordHash, category) VALUES
            ('u1', 'org1@example.com', 'org1', 'hashedpassword1', 'Org'),
            ('u2', 'donor1@example.com', 'donor1', 'hashedpassword2', 'Donar');",

"INSERT INTO Organization (organizationId, organizationName, registeredUserId) VALUES
('o1', 'Organization 1', 'u1');",

"INSERT INTO Donor (donorId, donationId, roleDetails, registeredUserId) VALUES
('xyz123-donor', NULL, 'Donor Role Description', 'u2');
",

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
