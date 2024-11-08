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
                `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `types` ENUM('Guest', 'RegisteredUserType'),
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

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

            // Create Organization Table
            "CREATE TABLE Organization (
                `id` INT NOT NULL DEFAULT 1 PRIMARY KEY,
                `name` VARCHAR(100) NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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

            // Create Donor Table
            "CREATE TABLE Donor (
                `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `registered_user_id` INT NOT NULL,  
                `organization_id` INT,  
                `donation_details` TEXT,  
                FOREIGN KEY (`registered_user_id`) REFERENCES RegisteredUserType(`id`) ON DELETE CASCADE,
                FOREIGN KEY (`organization_id`) REFERENCES Organization(`id`) ON DELETE CASCADE
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

            // Insert into Users
            "INSERT INTO Users (`types`) VALUES ('RegisteredUserType');",

            // Insert into RegisteredUserType (for Donor)
            "INSERT INTO RegisteredUserType (`email`, `userName`, `passwordHash`, `category`, `id`) 
            VALUES ('donor@example.com', 'DonorUser', 'hashedpassword123', 'Donor', LAST_INSERT_ID());",

            // Insert into RegisteredUserType (for Volunteer)
            "INSERT INTO RegisteredUserType (`email`, `userName`, `passwordHash`, `category`, `id`) 
            VALUES ('volunteer@example.com', 'VolunteerUser', 'hashedpassword456', 'Volunteer', LAST_INSERT_ID());",

            // Insert into Donor
            "INSERT INTO Donor (`registered_user_id`, `organization_id`, `donation_details`) 
            VALUES (LAST_INSERT_ID(), 1, 'Donated money for children education.');",

            // Insert into Volunteer
            "INSERT INTO Volunteer (`registered_user_id`, `organization_id`, `other_volunteer_specific_field`) 
            VALUES (LAST_INSERT_ID(), 1, 'Helping with event management.');",

         ], true);
    }
}
?>
