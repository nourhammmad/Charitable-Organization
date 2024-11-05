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
                )DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"

    
            // "CREATE TABLE Donations (
            //     donationId INT AUTO_INCREMENT PRIMARY KEY,
            //     userId CHAR(36),
            //     quantity INT NOT NULL,
            //     type ENUM('Book', 'Clothes', 'Food', 'Money'),
            //     donation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            //     FOREIGN KEY (userId) REFERENCES Users(id) ON DELETE SET NULL
            // ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
    
            // "CREATE TABLE Events (
            //     eventId INT AUTO_INCREMENT PRIMARY KEY,
            //     date DATE NOT NULL,
            //     address VARCHAR(255) NOT NULL,
            //     EventAttendanceCapacity INT NOT NULL,
            //     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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