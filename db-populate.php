<?php
require_once "Database.php";

class Populate {
    public static function populate() {
        Database::run_queries(
            [
                "SET FOREIGN_KEY_CHECKS = 0;",
                "DROP TABLE IF EXISTS donationtypes, address, books, clothes, event, eventvolunteer, money, users, payments, donations, registeredusertype, events, tasks, donationitem, donationmanagement, donor, organization, ipayment, cash, visa, instapay;",
                "SET FOREIGN_KEY_CHECKS = 1;", 

                // Create Users Table
                "CREATE TABLE Users (
                    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `types` ENUM('Guest', 'RegisteredUserType'),
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                // Insert sample users
                "INSERT INTO Users (`types`) VALUES 
                    ('RegisteredUserType'), 
                    ('Guest');",

                // Create RegisteredUserType Table
                "CREATE TABLE RegisteredUserType (
                    `id` INT NOT NULL,
                    `email` VARCHAR(50) UNIQUE NOT NULL,
                    `userName` VARCHAR(50) UNIQUE NOT NULL,
                    `passwordHash` VARCHAR(255) NOT NULL,
                    `category` ENUM('Volunteer', 'Donor'),
                    PRIMARY KEY (`id`),
                    FOREIGN KEY (`id`) REFERENCES Users(`id`) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                // Insert sample RegisteredUserType
                "INSERT INTO RegisteredUserType (`id`, `email`, `userName`, `passwordHash`, `category`) VALUES 
                    (1, 'john.doe@example.com', 'john_doe', 'hashedpassword1', 'Donor'),
                    (2, 'jane.smith@example.com', 'jane_smith', 'hashedpassword2', 'Volunteer');",

                // Create Organization Table
                "CREATE TABLE Organization (
                    `id` INT NOT NULL DEFAULT 1 PRIMARY KEY,  
                    `name` VARCHAR(100) NOT NULL,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    CONSTRAINT unique_organization UNIQUE (`id`)  
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                // Insert into Organization
                "INSERT INTO Organization (`name`) VALUES ('My Charitable Organization');",

                // Create Volunteer Table
                "CREATE TABLE Volunteer (
                    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `registered_user_id` INT NOT NULL,  
                    `organization_id` INT,  
                    `other_volunteer_specific_field` VARCHAR(255),  
                    FOREIGN KEY (`registered_user_id`) REFERENCES RegisteredUserType(`id`) ON DELETE CASCADE,
                    FOREIGN KEY (`organization_id`) REFERENCES Organization(`id`) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

              "CREATE TABLE DonationType (
                `donationId` CHAR(36) PRIMARY KEY,
                `quantityDonated` INT NOT NULL
                )DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",


                "CREATE TABLE Donor (
                    `donorId` CHAR(36) PRIMARY KEY,
                    `donationId` CHAR(36),
                    `roleDetails` TEXT,
                    FOREIGN KEY (donationId) REFERENCES DonationType(donationId) ON DELETE SET NULL
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                    
                    "CREATE TABLE Organization (
                        `organizationId` INT AUTO_INCREMENT PRIMARY KEY,
                        `organizationName` VARCHAR(255) NOT NULL
                    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                
                "CREATE TABLE OrganizationDonor (
                    `organizationId` CHAR(36),
                    `donorId` CHAR(36),
                    PRIMARY KEY (organizationId, donorId),
                    FOREIGN KEY (organizationId) REFERENCES Organization(organizationId) ON DELETE CASCADE,
                    FOREIGN KEY (donorId) REFERENCES Donor(donorId) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"


    
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
?>
