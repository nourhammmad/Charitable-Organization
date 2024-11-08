<?php
require_once "Database.php";

class Populate {
    public static function populate() {
        Database::run_queries(
            [
                "SET FOREIGN_KEY_CHECKS = 0;",
                "DROP TABLE IF EXISTS event,eventvolunteer,address,Users, bookdonation, clothesdonation, moneydonation, Payments, Donations, 
                RegisteredUserType, Events, Tasks, DonationType, Donor, Organization, DonationItem, 
                DonationManagement, Clothes, Books, Money, IPayment, Cash, Visa, Instapay,Volunteer,DonationTypes;",
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

                // Insert into Volunteer Table
                "INSERT INTO Volunteer (`registered_user_id`, `organization_id`, `other_volunteer_specific_field`) VALUES 
                    (2, 1, 'Event Coordinator');",

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

                // Create Payment Table
                "CREATE TABLE Payments (
                    `payment_id` INT AUTO_INCREMENT PRIMARY KEY,
                    `donor_id` INT,
                    `payment_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    `amount` DECIMAL(10, 2) NOT NULL,
                    `payment_method` ENUM('Cash', 'Visa', 'Instapay') NOT NULL,
                    `status` ENUM('Pending', 'Completed', 'Failed') NOT NULL,
                    FOREIGN KEY (`donor_id`) REFERENCES Donor(`id`) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                // Create Cash Table
                "CREATE TABLE Cash (
                    `payment_id` INT NOT NULL,
                    `transaction_id` VARCHAR(100) UNIQUE,
                    FOREIGN KEY (`payment_id`) REFERENCES Payments(`payment_id`) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                // Create Visa Table
                "CREATE TABLE Visa (
                    `payment_id` INT NOT NULL,
                    `transaction_number` VARCHAR(100) UNIQUE,
                    `card_number` VARCHAR(50),
                    FOREIGN KEY (`payment_id`) REFERENCES Payments(`payment_id`) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                // Create Instapay Table
                "CREATE TABLE Instapay (
                    `payment_id` INT NOT NULL,
                    `transaction_reference` VARCHAR(100) UNIQUE,
                    `account_number` VARCHAR(50),
                    FOREIGN KEY (`payment_id`) REFERENCES Payments(`payment_id`) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                // Insert Payments into Payments Table
                "INSERT INTO Payments (`donor_id`, `amount`, `payment_method`, `status`) VALUES
                    (1, 500.00, 'Cash', 'Completed'),
                    (1, 200.00, 'Visa', 'Completed'),
                    (1, 300.00, 'Instapay', 'Pending');",
                    // Insert Payments into Payments Table
                    "INSERT INTO Payments (`donor_id`, `amount`, `payment_method`, `status`) VALUES
                    (1, 500.00, 'Cash', 'Completed'),
                    (1, 200.00, 'Visa', 'Completed'),
                    (1, 300.00, 'Instapay', 'Pending');",

// Insert into Cash Table
"INSERT INTO Cash (`payment_id`, `transaction_id`) VALUES
(1, 'TXN12345'),
(2, 'TXN67890');",

// Insert into Visa Table
"INSERT INTO Visa (`payment_id`, `transaction_number`, `card_number`) VALUES
(2, 'VISA78901', '4111111111111111');",

// Insert into Instapay Table
"INSERT INTO Instapay (`payment_id`, `transaction_reference`, `account_number`) VALUES
(3, 'INSTAPAY112233', '9876543210');",

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
            addressId CHAR(36),  -- No foreign key constraint
            EventAttendanceCapacity INT NOT NULL,
            tickets INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT = 1;",

                               
                    // Insert test Event
                    "INSERT INTO Event (date, addressId, EventAttendanceCapacity, tickets) VALUES
                        ('2024-12-01', (SELECT addressId FROM Address LIMIT 1), 100, 50);",

                        "INSERT INTO Event (date, addressId, EventAttendanceCapacity, tickets) 
                        VALUES 
                            ('2024-12-01', (SELECT addressId FROM Address LIMIT 1), 6, 5);",

                            "INSERT INTO Event (date, addressId, EventAttendanceCapacity, tickets) 
                            VALUES ('2024-12-01', 'some-random-address-id', 100, 50);",
                            
                     
 
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
                        (1, 1);",
                    // Create Address Table... by Brwana ahmed mourad mohamed inrahim ali farhan 20P1346

                   // Create Address Table
                 


            
            ],true,
       

        );
    }
}
?>
