<?php
// require_once "Database.php";
 
// class Populate {
//     public static function populate() {
//         Database::run_queries(
//             [
//                 "SET FOREIGN_KEY_CHECKS = 0;",
//                 "DROP TABLE IF EXISTS donationtypes, address, books, clothes, event, eventvolunteer, money, users, payments, donations, registeredusertype, events, tasks, donationitem, donationmanagement, donor, organization, ipayment, cash, visa, instapay;",
//                 "SET FOREIGN_KEY_CHECKS = 1;",
 
//                 // Create Users Table
//                 "CREATE TABLE Users (
//                     `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
//                     `types` ENUM('Guest', 'RegisteredUserType'),
//                     `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert sample users
//                 "INSERT INTO Users (`types`) VALUES
//                     ('RegisteredUserType'),
//                     ('Guest');",
 
//                 // Create RegisteredUserType Table
//                 "CREATE TABLE RegisteredUserType (
//                     `id` INT NOT NULL,
//                     `email` VARCHAR(50) UNIQUE NOT NULL,
//                     `userName` VARCHAR(50) UNIQUE NOT NULL,
//                     `passwordHash` VARCHAR(255) NOT NULL,
//                     `category` ENUM('Volunteer', 'Donor'),
//                     PRIMARY KEY (`id`),
//                     FOREIGN KEY (`id`) REFERENCES Users(`id`) ON DELETE CASCADE
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert sample RegisteredUserType
//                 "INSERT INTO RegisteredUserType (`id`, `email`, `userName`, `passwordHash`, `category`) VALUES
//                     (1, 'john.doe@example.com', 'john_doe', 'hashedpassword1', 'Donor'),
//                     (2, 'jane.smith@example.com', 'jane_smith', 'hashedpassword2', 'Volunteer');",
 
//                 //Create Organization Table
//                 "CREATE TABLE Organization (
//                     `id` INT NOT NULL PRIMARY KEY,  
//                     `name` VARCHAR(100) NOT NULL,
//                     `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//                     CONSTRAINT unique_organization UNIQUE (`id`)  
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert into Organization
//                 "INSERT INTO Organization (`name`) VALUES ('My Charitable Organization');",
 
//                 // Create Volunteer Table
//                 "CREATE TABLE Volunteer (
//                     `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
//                     `registered_user_id` INT NOT NULL,  
//                     `organization_id` INT NOT NULL ,  
//                     `other_volunteer_specific_field` VARCHAR(255),  
//                     FOREIGN KEY (`registered_user_id`) REFERENCES RegisteredUserType(`id`) ON DELETE CASCADE,
//                     FOREIGN KEY (`organization_id`) REFERENCES Organization(`id`) ON DELETE CASCADE
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert into Volunteer Table
//                 "INSERT INTO Volunteer (`registered_user_id`, `organization_id`, `other_volunteer_specific_field`) VALUES
//                     (2, 1, 'Event Coordinator');",
 
 
 
               
// // "CREATE TABLE Organization (
// //     `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,  
// //     `name` VARCHAR(100) NOT NULL,
// //     `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
// // ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
 
// // "INSERT INTO Organization (`name`) VALUES ('My Charitable Organization');",
 
 
// // "CREATE TABLE Volunteer (
// //     `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
// //     `registered_user_id` INT NOT NULL,  
// //     `organization_id` INT NOT NULL,  
// //     `other_volunteer_specific_field` VARCHAR(255),  
// //     FOREIGN KEY (`registered_user_id`) REFERENCES RegisteredUserType(`id`) ON DELETE CASCADE,
// //     FOREIGN KEY (`organization_id`) REFERENCES Organization(`id`) ON DELETE CASCADE
// // ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
 
// // "INSERT INTO Volunteer (`registered_user_id`, `organization_id`, `other_volunteer_specific_field`) VALUES
// //     (2, 1, 'Event Coordinator');",
 
 
 
 
 
//                 // Create Donor Table
//                 "CREATE TABLE Donor (
//                     `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
//                     `registered_user_id` INT NOT NULL,  
//                     `organization_id` INT,  
//                     `donation_details` TEXT,  
//                     FOREIGN KEY (`registered_user_id`) REFERENCES RegisteredUserType(`id`) ON DELETE CASCADE,
//                     FOREIGN KEY (`organization_id`) REFERENCES Organization(`id`) ON DELETE CASCADE
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert into Donor Table
//                 "INSERT INTO Donor (`registered_user_id`, `organization_id`, `donation_details`) VALUES
//                     (1, 1, 'Donation of $1000 for charity event');",
 
//                 // Create DonationManagement Table
//                 "CREATE TABLE DonationManagement (
//                     `donation_management_id` INT AUTO_INCREMENT PRIMARY KEY,
//                     `organization_id` INT,
//                     `donation_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//                     FOREIGN KEY (organization_id) REFERENCES Organization(id) ON DELETE CASCADE,
//                     UNIQUE (`organization_id`)  
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert a single DonationManagement record for the organization
//                 "INSERT INTO DonationManagement (`organization_id`) VALUES
//                     (1);",
 
//                 // Create DonationTypes Table (Parent Table)
//                 "CREATE TABLE DonationTypes (
//                     `donation_type_id` INT AUTO_INCREMENT PRIMARY KEY,
//                     `type_name` ENUM('Money', 'Books', 'Clothes') NOT NULL
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert DonationTypes (Money, Books, Clothes)
//                 "INSERT INTO DonationTypes (`type_name`) VALUES
//                     ('Money'),
//                     ('Books'),
//                     ('Clothes');",
 
//                 // Create Money Table (Child Table)
//                 "CREATE TABLE Money (
//                     `money_id` INT AUTO_INCREMENT PRIMARY KEY,
//                     `donation_type_id` INT,
//                     `donation_management_id` INT,
//                     `amount` DECIMAL(10, 2) NOT NULL,
//                     `currency` VARCHAR(10) DEFAULT 'USD',
//                     `date_donated` DATETIME,
//                     FOREIGN KEY (donation_type_id) REFERENCES DonationTypes(donation_type_id) ON DELETE CASCADE,
//                     FOREIGN KEY (donation_management_id) REFERENCES DonationManagement(donation_management_id) ON DELETE CASCADE
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert Money Donation
//                 "INSERT INTO Money (`donation_type_id`, `donation_management_id`, `amount`, `currency`, `date_donated`) VALUES
//                     (1, 1, 1000.00, 'USD', '2024-11-01 12:00:00');",
 
//                 // Create Books Table (Child Table)
//                 "CREATE TABLE Books (
//                     `book_id` INT AUTO_INCREMENT PRIMARY KEY,
//                     `donation_type_id` INT,
//                     `donation_management_id` INT,
//                     `book_title` VARCHAR(255),
//                     `author` VARCHAR(255),
//                     `publication_year` INT,
//                     `quantity` INT,
//                     `date_donated` DATETIME,
//                     FOREIGN KEY (donation_type_id) REFERENCES DonationTypes(donation_type_id) ON DELETE CASCADE,
//                     FOREIGN KEY (donation_management_id) REFERENCES DonationManagement(donation_management_id) ON DELETE CASCADE
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert Books Donation
//                 "INSERT INTO Books (`donation_type_id`, `donation_management_id`, `book_title`, `author`, `publication_year`, `quantity`, `date_donated`) VALUES
//                     (2, 1, 'The Great Gatsby', 'F. Scott Fitzgerald', 1925, 10, '2024-11-01 12:00:00');",
 
//                 // Create Clothes Table (Child Table)
//                 "CREATE TABLE Clothes (
//                     `clothes_id` INT AUTO_INCREMENT PRIMARY KEY,
//                     `donation_type_id` INT,
//                     `donation_management_id` INT,
//                     `clothes_type` VARCHAR(100),
//                     `size` VARCHAR(50),
//                     `color` VARCHAR(50),
//                     `quantity` INT,
//                     `date_donated` DATETIME,
//                     FOREIGN KEY (donation_type_id) REFERENCES DonationTypes(donation_type_id) ON DELETE CASCADE,
//                     FOREIGN KEY (donation_management_id) REFERENCES DonationManagement(donation_management_id) ON DELETE CASCADE
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert Clothes Donation
//                 "INSERT INTO Clothes (`donation_type_id`, `donation_management_id`, `clothes_type`, `size`, `color`, `quantity`, `date_donated`) VALUES
//                     (3, 1, 'Winter Jacket', 'L', 'Red', 20, '2024-11-01 12:00:00');",
 
//                 // Create DonationItem Table
//                 "CREATE TABLE DonationItem (
//                     `donation_item_id` INT AUTO_INCREMENT PRIMARY KEY,
//                     `donation_management_id` INT,
//                     `donation_type_id` INT,
//                     `description` TEXT,
//                     `date_donated` DATETIME,
//                     FOREIGN KEY (donation_management_id) REFERENCES DonationManagement(donation_management_id) ON DELETE CASCADE,
//                     FOREIGN KEY (donation_type_id) REFERENCES DonationTypes(donation_type_id)
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert data into DonationItem table
//                 "INSERT INTO DonationItem (`donation_management_id`, `donation_type_id`, `description`, `date_donated`) VALUES
//                     (1, 1, 'Cash donation of $1000 for charity event', '2024-11-01 12:00:00'),
//                     (1, 2, '10 books including The Great Gatsby', '2024-11-01 12:00:00'),
//                     (1, 3, '20 winter jackets', '2024-11-01 12:00:00');",
                   
//                     "CREATE TABLE Address (
//                         addressId CHAR(36) PRIMARY KEY,
//                         street VARCHAR(255),
//                         floor INT,
//                         apartment INT,
//                         city VARCHAR(100)
//                     ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                     // Insert sample address
//                     "INSERT INTO Address (addressId, street, floor, apartment, city) VALUES
//                         (UUID(), '123 Main St', 5, 101, 'New York');",
 
 
 
//                 "CREATE TABLE Event (
//                         eventId INT AUTO_INCREMENT PRIMARY KEY,
//                         date DATE NOT NULL,
//                         addressId CHAR(36),
//                         EventAttendanceCapacity INT NOT NULL,
//                         tickets INT,
//                         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//                         FOREIGN KEY (addressId) REFERENCES Address(addressId) ON DELETE SET NULL
//                     ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT = 1;",
 
//                     // Insert test Event
//                     "INSERT INTO Event (date, addressId, EventAttendanceCapacity, tickets) VALUES
//                         ('2024-12-01', (SELECT addressId FROM Address LIMIT 1), 100, 50);",
 
//                     // Create EventVolunteer Table to link Events and Volunteers
//                     "CREATE TABLE EventVolunteer (
//                         eventId INT,
//                         volunteerId INT,
//                         PRIMARY KEY (eventId, volunteerId),
//                         FOREIGN KEY (eventId) REFERENCES Event(eventId) ON DELETE CASCADE,
//                         FOREIGN KEY (volunteerId) REFERENCES Volunteer(id) ON DELETE CASCADE
//                     ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                     // Insert a Volunteer association with the Event
//                     "INSERT INTO EventVolunteer (eventId, volunteerId) VALUES
//                         (1, 1);"
//             ]
//         );
//     }
// }
?>
 
 
<?php
// require_once "Database.php";
 
// class Populate {
//     public static function populate() {
//         Database::run_queries(
//             [
//                 // Disable foreign key checks to drop tables
//                 "SET FOREIGN_KEY_CHECKS = 0;",
//                 "DROP TABLE IF EXISTS EventVolunteer, Event, Address, Volunteer, Organization, RegisteredUserType, Users, DonationTypes, DonationManagement, Money, Books, Clothes, DonationItem;",
//                 "SET FOREIGN_KEY_CHECKS = 1;",
 
//                 // Create Users Table
//                 "CREATE TABLE Users (
//                     `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
//                     `types` ENUM('Guest', 'RegisteredUserType'),
//                     `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert sample users
//                 "INSERT INTO Users (`types`) VALUES
//                     ('RegisteredUserType'),
//                     ('Guest');",
 
//                 // Create RegisteredUserType Table
//                 "CREATE TABLE RegisteredUserType (
//                     `id` INT NOT NULL PRIMARY KEY,
//                     `email` VARCHAR(50) UNIQUE NOT NULL,
//                     `userName` VARCHAR(50) UNIQUE NOT NULL,
//                     `passwordHash` VARCHAR(255) NOT NULL,
//                     `category` ENUM('Volunteer', 'Donor'),
//                     FOREIGN KEY (`id`) REFERENCES Users(`id`) ON DELETE CASCADE
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert sample RegisteredUserType
//                 "INSERT INTO RegisteredUserType (`id`, `email`, `userName`, `passwordHash`, `category`) VALUES
//                     (1, 'john.doe@example.com', 'john_doe', 'hashedpassword1', 'Donor'),
//                     (2, 'jane.smith@example.com', 'jane_smith', 'hashedpassword2', 'Volunteer');",
 
//                 // Create Organization Table
//                 "CREATE TABLE Organization (
//                     `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,  
//                     `name` VARCHAR(100) NOT NULL,
//                     `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert into Organization
//                 "INSERT INTO Organization (`name`) VALUES ('My Charitable Organization');",
 
//                 // Create Volunteer Table
//                 "CREATE TABLE Volunteer (
//                     `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
//                     `registered_user_id` INT NOT NULL,  
//                     `organization_id` INT NOT NULL,  
//                     `other_volunteer_specific_field` VARCHAR(255),  
//                     FOREIGN KEY (`registered_user_id`) REFERENCES RegisteredUserType(`id`) ON DELETE CASCADE,
//                     FOREIGN KEY (`organization_id`) REFERENCES Organization(`id`) ON DELETE CASCADE
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert into Volunteer Table
//                 "INSERT INTO Volunteer (`registered_user_id`, `organization_id`, `other_volunteer_specific_field`) VALUES
//                     (2, 1, 'Event Coordinator');",
 
//                 // Create DonationManagement Table
//                 "CREATE TABLE DonationManagement (
//                     `donation_management_id` INT AUTO_INCREMENT PRIMARY KEY,
//                     `organization_id` INT,
//                     `donation_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//                     FOREIGN KEY (organization_id) REFERENCES Organization(id) ON DELETE CASCADE
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert a single DonationManagement record for the organization
//                 "INSERT INTO DonationManagement (`organization_id`) VALUES
//                     (1);",
 
//                 // Create DonationTypes Table (Parent Table)
//                 "CREATE TABLE DonationTypes (
//                     `donation_type_id` INT AUTO_INCREMENT PRIMARY KEY,
//                     `type_name` ENUM('Money', 'Books', 'Clothes') NOT NULL
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert DonationTypes (Money, Books, Clothes)
//                 "INSERT INTO DonationTypes (`type_name`) VALUES
//                     ('Money'),
//                     ('Books'),
//                     ('Clothes');",
 
//                 // Create Money Table (Child Table)
//                 "CREATE TABLE Money (
//                     `money_id` INT AUTO_INCREMENT PRIMARY KEY,
//                     `donation_type_id` INT,
//                     `donation_management_id` INT,
//                     `amount` DECIMAL(10, 2) NOT NULL,
//                     `currency` VARCHAR(10) DEFAULT 'USD',
//                     `date_donated` DATETIME,
//                     FOREIGN KEY (donation_type_id) REFERENCES DonationTypes(donation_type_id) ON DELETE CASCADE,
//                     FOREIGN KEY (donation_management_id) REFERENCES DonationManagement(donation_management_id) ON DELETE CASCADE
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Create Address Table
//                 "CREATE TABLE Address (
//                     addressId CHAR(36) PRIMARY KEY,
//                     street VARCHAR(255),
//                     floor INT,
//                     apartment INT,
//                     city VARCHAR(100)
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert sample address
//                 "INSERT INTO Address (addressId, street, floor, apartment, city) VALUES
//                     (UUID(), '123 Main St', 5, 101, 'New York');",
 
//                 // Create Event Table
//                 "CREATE TABLE Event (
//                     eventId INT AUTO_INCREMENT PRIMARY KEY,
//                     date DATE NOT NULL,
//                     addressId CHAR(36),
//                     EventAttendanceCapacity INT NOT NULL,
//                     tickets INT,
//                     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//                     FOREIGN KEY (addressId) REFERENCES Address(addressId) ON DELETE SET NULL
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT = 1;",
 
//                 // Insert test Event
//                 "INSERT INTO Event (date, addressId, EventAttendanceCapacity, tickets) VALUES
//                     ('2024-12-01', (SELECT addressId FROM Address LIMIT 1), 100, 50);",
 
//                 // Create EventVolunteer Table to link Events and Volunteers
//                 "CREATE TABLE EventVolunteer (
//                     eventId INT,
//                     volunteerId INT,
//                     PRIMARY KEY (eventId, volunteerId),
//                     FOREIGN KEY (eventId) REFERENCES Event(eventId) ON DELETE CASCADE,
//                     FOREIGN KEY (volunteerId) REFERENCES Volunteer(id) ON DELETE CASCADE
//                 ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
//                 // Insert a Volunteer association with the Event
//                 "INSERT INTO EventVolunteer (eventId, volunteerId) VALUES
//                     (1, 1);"
//             ]
//         );
//     }
// }
?>
<?php
require_once "Database.php";
 
class Populate {
    public static function populate() {
        Database::run_queries(
            [
                "SET FOREIGN_KEY_CHECKS = 0;",
                "DROP TABLE IF EXISTS donationtypes, address, books, Volunteer ,clothes, event, eventvolunteer, money, users, payments, donations, registeredusertype, events, tasks, donationitem, donationmanagement, donor, organization, ipayment, cash, visa, instapay;",
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
                    `id` INT NOT NULL PRIMARY KEY,  
                    `name` VARCHAR(100) NOT NULL,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
                // Insert into Organization
                "INSERT INTO Organization (`id`, `name`) VALUES
                    (1, 'My Charitable Organization');",
 
                // Continue with other tables...
                // Create Volunteer Table
                "CREATE TABLE Volunteer (
                    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `registered_user_id` INT NOT NULL,  
                    `organization_id` INT,  
                    `other_volunteer_specific_field` VARCHAR(255),  
                    FOREIGN KEY (`registered_user_id`) REFERENCES RegisteredUserType(`id`) ON DELETE CASCADE,
                    FOREIGN KEY (`organization_id`) REFERENCES Organization(`id`) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
                // Insert into Volunteer Table
                "INSERT INTO Volunteer (`registered_user_id`, `organization_id`, `other_volunteer_specific_field`) VALUES
                    (2, 1, 'Event Coordinator');",


                " CREATE TABLE Tasks (
                    id INT PRIMARY KEY AUTO_INCREMENT, -- Unique identifier for each task, with auto-increment
                    name VARCHAR(255) NOT NULL, -- Name of the task
                    description TEXT NOT NULL, -- Detailed description of the task
                    requiredSkill VARCHAR(255), -- Skills required for the task
                    timeSlot VARCHAR(255), -- Time slot for the task
                    location VARCHAR(255) -- Location where the task will take place
                );",    
            
                // Create Donor Table
                "CREATE TABLE Donor (
                    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `registered_user_id` INT NOT NULL,  
                    `organization_id` INT,  
                    `donation_details` TEXT,  
                    FOREIGN KEY (`registered_user_id`) REFERENCES RegisteredUserType(`id`) ON DELETE CASCADE,
                    FOREIGN KEY (`organization_id`) REFERENCES Organization(`id`) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
                // Insert into Donor Table
                "INSERT INTO Donor (`registered_user_id`, `organization_id`, `donation_details`) VALUES
                    (1, 1, 'Donation of $1000 for charity event');",
 
                // Create DonationManagement Table
                "CREATE TABLE DonationManagement (
                    `donation_management_id` INT AUTO_INCREMENT PRIMARY KEY,
                    `organization_id` INT,
                    `donation_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (organization_id) REFERENCES Organization(id) ON DELETE CASCADE,
                    UNIQUE (`organization_id`)  
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
                // Insert a single DonationManagement record for the organization
                "INSERT INTO DonationManagement (`organization_id`) VALUES
                    (1);",
 
                // Create DonationTypes Table (Parent Table)
                "CREATE TABLE DonationTypes (
                    `donation_type_id` INT AUTO_INCREMENT PRIMARY KEY,
                    `type_name` ENUM('Money', 'Books', 'Clothes') NOT NULL
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
                // Insert DonationTypes (Money, Books, Clothes)
                "INSERT INTO DonationTypes (`type_name`) VALUES
                    ('Money'),
                    ('Books'),
                    ('Clothes');",
 
                // Create Money Table (Child Table)
                "CREATE TABLE Money (
                    `money_id` INT AUTO_INCREMENT PRIMARY KEY,
                    `donation_type_id` INT,
                    `donation_management_id` INT,
                    `amount` DECIMAL(10, 2) NOT NULL,
                    `currency` VARCHAR(10) DEFAULT 'USD',
                    `date_donated` DATETIME,
                    FOREIGN KEY (donation_type_id) REFERENCES DonationTypes(donation_type_id) ON DELETE CASCADE,
                    FOREIGN KEY (donation_management_id) REFERENCES DonationManagement(donation_management_id) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
                // Insert Money Donation
                "INSERT INTO Money (`donation_type_id`, `donation_management_id`, `amount`, `currency`, `date_donated`) VALUES
                    (1, 1, 1000.00, 'USD', '2024-11-01 12:00:00');",
 
                // Create Books Table (Child Table)
                "CREATE TABLE Books (
                    `book_id` INT AUTO_INCREMENT PRIMARY KEY,
                    `donation_type_id` INT,
                    `donation_management_id` INT,
                    `book_title` VARCHAR(255),
                    `author` VARCHAR(255),
                    `publication_year` INT,
                    `quantity` INT,
                    `date_donated` DATETIME,
                    FOREIGN KEY (donation_type_id) REFERENCES DonationTypes(donation_type_id) ON DELETE CASCADE,
                    FOREIGN KEY (donation_management_id) REFERENCES DonationManagement(donation_management_id) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
                // Insert Books Donation
                "INSERT INTO Books (`donation_type_id`, `donation_management_id`, `book_title`, `author`, `publication_year`, `quantity`, `date_donated`) VALUES
                    (2, 1, 'The Great Gatsby', 'F. Scott Fitzgerald', 1925, 10, '2024-11-01 12:00:00');",
 
                // Create Clothes Table (Child Table)
                "CREATE TABLE Clothes (
                    `clothes_id` INT AUTO_INCREMENT PRIMARY KEY,
                    `donation_type_id` INT,
                    `donation_management_id` INT,
                    `clothes_type` VARCHAR(100),
                    `size` VARCHAR(50),
                    `color` VARCHAR(50),
                    `quantity` INT,
                    `date_donated` DATETIME,
                    FOREIGN KEY (donation_type_id) REFERENCES DonationTypes(donation_type_id) ON DELETE CASCADE,
                    FOREIGN KEY (donation_management_id) REFERENCES DonationManagement(donation_management_id) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
                // Insert Clothes Donation
                "INSERT INTO Clothes (`donation_type_id`, `donation_management_id`, `clothes_type`, `size`, `color`, `quantity`, `date_donated`) VALUES
                    (3, 1, 'Winter Jacket', 'L', 'Red', 20, '2024-11-01 12:00:00');",
 
                // Create DonationItem Table
                "CREATE TABLE DonationItem (
                    `donation_item_id` INT AUTO_INCREMENT PRIMARY KEY,
                    `donation_management_id` INT,
                    `donation_type_id` INT,
                    `description` TEXT,
                    `date_donated` DATETIME,
                    FOREIGN KEY (donation_management_id) REFERENCES DonationManagement(donation_management_id) ON DELETE CASCADE,
                    FOREIGN KEY (donation_type_id) REFERENCES DonationTypes(donation_type_id)
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
                // Insert data into DonationItem table
                "INSERT INTO DonationItem (`donation_management_id`, `donation_type_id`, `description`, `date_donated`) VALUES
                    (1, 1, 'Cash donation of $1000 for charity event', '2024-11-01 12:00:00'),
                    (1, 2, '10 books including The Great Gatsby', '2024-11-01 12:00:00'),
                    (1, 3, '20 winter jackets', '2024-11-01 12:00:00');",
                   
                    "CREATE TABLE Address (
                        addressId CHAR(36) PRIMARY KEY,
                        street VARCHAR(255),
                        floor INT,
                        apartment INT,
                        city VARCHAR(100)
                    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
                    // Insert sample address
                    "INSERT INTO Address (addressId, street, floor, apartment, city) VALUES
                        (UUID(), '123 Main St', 5, 101, 'New York');",
 
 
 
                "CREATE TABLE Event (
                        eventId INT AUTO_INCREMENT PRIMARY KEY,
                        date DATE NOT NULL,
                        addressId CHAR(36),
                        EventAttendanceCapacity INT NOT NULL,
                        tickets INT,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        FOREIGN KEY (addressId) REFERENCES Address(addressId) ON DELETE SET NULL
                    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT = 1;",
 
                    // Insert test Event
                    "INSERT INTO Event (date, addressId, EventAttendanceCapacity, tickets) VALUES
                        ('2024-12-01', (SELECT addressId FROM Address LIMIT 1), 100, 50);",
 
                    // Create EventVolunteer Table to link Events and Volunteers
                    "CREATE TABLE EventVolunteer (
                        eventId INT,
                        volunteerId INT,
                        PRIMARY KEY (eventId, volunteerId),
                        FOREIGN KEY (eventId) REFERENCES Event(eventId) ON DELETE CASCADE,
                        FOREIGN KEY (volunteerId) REFERENCES Volunteer(id) ON DELETE CASCADE
                    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
                    // Insert a Volunteer association with the Event
                    "INSERT INTO EventVolunteer (eventId, volunteerId) VALUES
                        (1, 1);"
            ]
        );
    }
}
?>
 
 