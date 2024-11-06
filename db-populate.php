<?php
require_once "Database.php";

class Populate {
    public static function populate() {
        Database::run_queries(
         [
            "SET FOREIGN_KEY_CHECKS = 0;",
            "DROP TABLE IF EXISTS Users;",
            "DROP TABLE IF EXISTS Payments;",
            "DROP TABLE IF EXISTS Donations;",
            "DROP TABLE IF EXISTS RegisteredUserType;",
            "DROP TABLE IF EXISTS Events;",
            "DROP TABLE IF EXISTS Tasks;",
            "DROP TABLE IF EXISTS DonationType;",
            "DROP TABLE IF EXISTS Donor;",
            "DROP TABLE IF EXISTS Organization;",
            "DROP TABLE IF EXISTS OrganizationDonor;",
            "DROP TABLE IF EXISTS DonationItem;",
            "DROP TABLE IF EXISTS DonationManagement;",
            "DROP TABLE IF EXISTS Clothes;",
            "DROP TABLE IF EXISTS Books;",

            "DROP TABLE IF EXISTS Money;",
            "DROP TABLE IF EXISTS IPayment;",
            "DROP TABLE IF EXISTS Cash;",

            "DROP TABLE IF EXISTS Visa;",
            "DROP TABLE IF EXISTS Instapay;",
            "DROP TABLE IF EXISTS DonationType;",
            "DROP TABLE IF EXISTS Organization;",

            "SET FOREIGN_KEY_CHECKS = 1;",
    
            "CREATE TABLE Users (
                `id` CHAR(36) NOT NULL PRIMARY KEY,
                `types` ENUM('Guest', 'RegisteredUserType'),
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                
            "CREATE TABLE RegisteredUserType (
                    `id` CHAR(36) NOT NULL,
                    `email` VARCHAR(50) UNIQUE NOT NULL,
                    `userName` VARCHAR(50) UNIQUE NOT NULL,
                    `passwordHash` VARCHAR(255) NOT NULL,
                    `category` Enum('Org','Donar'),
                    PRIMARY KEY (id),
                    FOREIGN KEY (id) REFERENCES Users(id) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

           " CREATE TABLE Tasks (
                `id` INT PRIMARY KEY AUTO_INCREMENT, -- Unique identifier for each task, with auto-increment
                `name` VARCHAR(255) NOT NULL, -- Name of the task
                `description` TEXT NOT NULL, -- Detailed description of the task
                `requiredSkill` VARCHAR(255), -- Skills required for the task
                `timeSlot` VARCHAR(255), -- Time slot for the task
                `location` VARCHAR(255) -- Location where the task will take place
            )DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            "CREATE TABLE DonationType (
            `donationId` CHAR(36) PRIMARY KEY,
            `quantityDonated` INT NOT NULL
            )DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",


            "CREATE TABLE Donor (
                `donorId` CHAR(36) PRIMARY KEY,
                `donationId` CHAR(36),
                `roleDetails` TEXT,
                `registeredUserId` CHAR(36) NOT NULL,
                FOREIGN KEY (donationId) REFERENCES DonationType(donationId) ON DELETE SET NULL,
                FOREIGN KEY (registeredUserId) REFERENCES RegisteredUserType(id) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            "CREATE TABLE Organization (
                `organizationId` CHAR(36) PRIMARY KEY,
                `organizationName` VARCHAR(255) NOT NULL,
                `registeredUserId` CHAR(36) NOT NULL,
                FOREIGN KEY (registeredUserId) REFERENCES RegisteredUserType(id) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            
            "CREATE TABLE OrganizationDonor (
                `organizationId` CHAR(36),
                `donorId` CHAR(36),
                PRIMARY KEY (organizationId, donorId),
                FOREIGN KEY (organizationId) REFERENCES Organization(organizationId) ON DELETE CASCADE,
                FOREIGN KEY (donorId) REFERENCES Donor(donorId) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            "CREATE TABLE Events (
            eventId INT AUTO_INCREMENT PRIMARY KEY,
            date DATE NOT NULL,
            address VARCHAR(255) NOT NULL,
            EventAttendanceCapacity INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            " CREATE TABLE DonationManagement (
            `donationManagementId` INT AUTO_INCREMENT PRIMARY KEY,
            `organizationId` CHAR(36) NOT NULL,
            `donationTypeId` CHAR(36) NOT NULL,
            FOREIGN KEY (`organizationId`) REFERENCES Organization(`organizationId`) ON DELETE CASCADE,
            FOREIGN KEY (`donationTypeId`) REFERENCES DonationType(`donationId`) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            "CREATE TABLE DonationItem (
            `donationItemId` INT AUTO_INCREMENT PRIMARY KEY,
            `donationManagementId` INT NOT NULL,
            `quantity` INT NOT NULL,
            FOREIGN KEY (`donationManagementId`) REFERENCES DonationManagement(`donationManagementId`) ON DELETE CASCADE
             ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
            
            "CREATE TABLE Clothes (
            `clothesId` CHAR(36) PRIMARY KEY,
            `donationId` CHAR(36) NOT NULL,  
            `clothingDescription` VARCHAR(255),
            FOREIGN KEY (`donationId`) REFERENCES DonationType(`donationId`) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            "CREATE TABLE Books (
            `bookId` CHAR(36) PRIMARY KEY,
            `donationId` CHAR(36) NOT NULL, 
            `bookTitle` VARCHAR(255),
            `bookAuthor` VARCHAR(255),
            FOREIGN KEY (`donationId`) REFERENCES DonationType(`donationId`) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            "CREATE TABLE IPayment (
                `paymentId` CHAR(36) PRIMARY KEY,
                `paymentMethod` VARCHAR(255) NOT NULL
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            "CREATE TABLE Money (
            `moneyId` CHAR(36) PRIMARY KEY,
            `donationId` CHAR(36) NOT NULL,  
            `amount` DECIMAL(10, 2) NOT NULL,
            `paymentId` CHAR(36),  
            FOREIGN KEY (`donationId`) REFERENCES DonationType(`donationId`) ON DELETE CASCADE,
            FOREIGN KEY (`paymentId`) REFERENCES IPayment(`paymentId`) ON DELETE SET NULL
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",



            "CREATE TABLE Cash (
                `cashId` CHAR(36) PRIMARY KEY,
                `paymentId` CHAR(36) NOT NULL,  -- Foreign key to IPayment
                `cashAmount` DECIMAL(10, 2) NOT NULL,
                FOREIGN KEY (`paymentId`) REFERENCES IPayment(`paymentId`) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            "CREATE TABLE Visa (
                `visaId` CHAR(36) PRIMARY KEY,
                `paymentId` CHAR(36) NOT NULL,  -- Foreign key to IPayment
                `cardNumber` VARCHAR(16) NOT NULL,
                `expiryDate` DATE NOT NULL,
                FOREIGN KEY (`paymentId`) REFERENCES IPayment(`paymentId`) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            "CREATE TABLE Instapay (
                `instapayId` CHAR(36) PRIMARY KEY,
                `paymentId` CHAR(36) NOT NULL,  -- Foreign key to IPayment
                `username` VARCHAR(255) NOT NULL,
                `transactionId` CHAR(36) NOT NULL,
                FOREIGN KEY (`paymentId`) REFERENCES IPayment(`paymentId`) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            "INSERT INTO Users (id, types, created_at) VALUES
            ('123e4567-e89b-12d3-a456-426614174000', 'RegisteredUserType', NOW()),
            ('123e4567-e89b-12d3-a456-426614174001', 'RegisteredUserType', NOW()),
            ('123e4567-e89b-12d3-a456-426614174002', 'RegisteredUserType', NOW()),
            ('123e4567-e89b-12d3-a456-426614174003', 'Guest', NOW()),
            ('123e4567-e89b-12d3-a456-426614174004', 'Guest', NOW());",

            "INSERT INTO RegisteredUserType (id, email, userName, passwordHash, category) VALUES
            ('123e4567-e89b-12d3-a456-426614174000', 'user1@example.com', 'UserOne', '123', 'Org'),
            ('123e4567-e89b-12d3-a456-426614174001', 'user2@example.com', 'UserTwo', '$2y$10$12344', 'Donar'),
            ('123e4567-e89b-12d3-a456-426614174002', 'user3@example.com', 'UserThree', '$2y$10$22222', 'Org');",





    
            // "CREATE TABLE Donations (
            //     donationId INT AUTO_INCREMENT PRIMARY KEY,
            //     userId CHAR(36),
            //     quantity INT NOT NULL,
            //     type ENUM('Book', 'Clothes', 'Food', 'Money'),
            //     donation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            //     FOREIGN KEY (userId) REFERENCES Users(id) ON DELETE SET NULL
            // ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
    
            
    
            // "CREATE TABLE Payments (
            //     paymentId INT AUTO_INCREMENT PRIMARY KEY,
            //     userId CHAR(36) NOT NULL,
            //     amount FLOAT NOT NULL,
            //     currencyType VARCHAR(10) NOT NULL,
            //     cardNumber VARCHAR(16) DEFAULT NULL,
            //     expiryDate VARCHAR(5) DEFAULT NULL,
            //     CVV INT DEFAULT NULL,
            //     accountID VARCHAR(50) DEFAULT NULL,
            //     accountHolderName VARCHAR(100) DEFAULT NULL,
            //     transactionFee FLOAT DEFAULT NULL,
            //     paymentMethod ENUM('Cash', 'Visa', 'Instapay') NOT NULL,
            //     status VARCHAR(20) DEFAULT 'Processed',
            //     payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            //     FOREIGN KEY (userId) REFERENCES Users(id) ON DELETE CASCADE
            // ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
            // "CREATE TABLE Donations (
                //     donationId INT AUTO_INCREMENT PRIMARY KEY,
                //     userId CHAR(36),
                //     quantity INT NOT NULL,
                //     type ENUM('Book', 'Clothes', 'Food', 'Money'),
                //     donation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                //     FOREIGN KEY (userId) REFERENCES Users(id)
                // );",
                
                // "CREATE TABLE Events (
                //     eventId INT AUTO_INCREMENT PRIMARY KEY,
                //     date DATE NOT NULL,
                //     address VARCHAR(255) NOT NULL,
                //     EventAttendanceCapacity INT NOT NULL,
                //     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                // );",
                
                // "CREATE TABLE Payments (
                //     paymentId INT AUTO_INCREMENT PRIMARY KEY,
                //     userId CHAR(36) NOT NULL,
                //     amount FLOAT NOT NULL,
                //     currencyType VARCHAR(10) NOT NULL,
                //     cardNumber VARCHAR(16) DEFAULT NULL,  -- Only for Visa
                //     expiryDate VARCHAR(5) DEFAULT NULL,   -- Only for Visa
                //     CVV INT DEFAULT NULL,                 -- Only for Visa
                //     accountID VARCHAR(50) DEFAULT NULL,   -- Only for Instapay
                //     accountHolderName VARCHAR(100) DEFAULT NULL, -- Only for Instapay
                //     transactionFee FLOAT DEFAULT NULL,    -- Only for Instapay
                //     paymentMethod ENUM('Cash', 'Visa', 'Instapay') NOT NULL,
                //     status VARCHAR(20) DEFAULT 'Processed',
                //     payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                //     FOREIGN KEY (userId) REFERENCES Users(id)
                // );",
                 // CREATE TABLE Organization (
            //     orgId INT AUTO_INCREMENT PRIMARY KEY,
            //     name VARCHAR(100) NOT NULL,
            //     address VARCHAR(255),
            //     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            // );
            
            // CREATE TABLE FamilyShelters (
            //     shelterId INT AUTO_INCREMENT PRIMARY KEY,
            //     NumberOfShelters INT NOT NULL,
            //     ShelterLocation VARCHAR(255) NOT NULL,
            //     Capacity INT NOT NULL,
            //     Facilities TEXT,
            //     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            // );
            
            // CREATE TABLE EducationalCenters (
            //     centerId INT AUTO_INCREMENT PRIMARY KEY,
            //     TargetGroup VARCHAR(50),
            //     NumberOfCenters INT NOT NULL,
            //     CenterLocation VARCHAR(255),
            //     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            // );
            
            // CREATE TABLE DonationItems (
            //     donationId INT AUTO_INCREMENT PRIMARY KEY,
            //     userId INT,
            //     quantity INT NOT NULL,
            //     type ENUM('Book', 'Clothes', 'Food', 'Money'),
            //     donation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            //     FOREIGN KEY (userId) REFERENCES Users(id)
            // );
            
            // CREATE TABLE Addresses (
            //     addressId INT AUTO_INCREMENT PRIMARY KEY,
            //     apartment INT,
            //     floor INT,
            //     street VARCHAR(100),
            //     city VARCHAR(50)
            // );
        ],
        true
);
}
}