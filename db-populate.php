<?php
require_once "Database.php";

class Populate {
    public static function populate() {
        try {
            Database::run_queries(
                [
                    // Disable foreign key checks
                    "SET FOREIGN_KEY_CHECKS = 0;",

                    // Drop existing tables if they exist
                    "DROP TABLE IF EXISTS Users, RegisteredUserType, Organization, Volunteer, Donor,
                     DonationManagement, DonationTypes, DonationItem, Address, Event, EventVolunteer;",

                    // Enable foreign key checks
                    "SET FOREIGN_KEY_CHECKS = 1;",

                    // Create Users Table
                    "CREATE TABLE Users (
                        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        types ENUM('Guest', 'RegisteredUserType'),
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                    // Insert sample users
                    "INSERT INTO Users (types) VALUES 
                        ('RegisteredUserType'), 
                        ('Guest');",

                    // Create RegisteredUserType Table
                    "CREATE TABLE RegisteredUserType (
                        id INT NOT NULL,
                        email VARCHAR(50) UNIQUE NOT NULL,
                        userName VARCHAR(50) UNIQUE NOT NULL,
                        passwordHash VARCHAR(255) NOT NULL,
                        category ENUM('Volunteer', 'Donor'),
                        PRIMARY KEY (id),
                        FOREIGN KEY (id) REFERENCES Users(id) ON DELETE CASCADE
                    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                    // Insert sample RegisteredUserType data
                    "INSERT INTO RegisteredUserType (id, email, userName, passwordHash, category) VALUES 
                        (1, 'john.doe@example.com', 'john_doe', 'hashedpassword1', 'Donor'),
                        (2, 'jane.smith@example.com', 'jane_smith', 'hashedpassword2', 'Volunteer');",

                    // Create Organization Table
                    "CREATE TABLE Organization (
                        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(100) NOT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                    // Insert into Organization
                    "INSERT INTO Organization (name) VALUES ('My Charitable Organization');",

                    // Create Volunteer Table
                    "CREATE TABLE Volunteer (
                        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        registered_user_id INT NOT NULL,
                        organization_id INT,
                        other_volunteer_specific_field VARCHAR(255),
                        FOREIGN KEY (registered_user_id) REFERENCES RegisteredUserType(id) ON DELETE CASCADE,
                        FOREIGN KEY (organization_id) REFERENCES Organization(id) ON DELETE CASCADE
                    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                    // Insert into Volunteer Table
                    "INSERT INTO Volunteer (registered_user_id, organization_id, other_volunteer_specific_field) VALUES 
                        (2, 1, 'Event Coordinator');",

                    // Create Donor Table
                    "CREATE TABLE Donor (
                        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        registered_user_id INT NOT NULL,
                        organization_id INT,
                        donation_details TEXT,
                        FOREIGN KEY (registered_user_id) REFERENCES RegisteredUserType(id) ON DELETE CASCADE,
                        FOREIGN KEY (organization_id) REFERENCES Organization(id) ON DELETE CASCADE
                    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                    // Insert into Donor Table
                    "INSERT INTO Donor (registered_user_id, organization_id, donation_details) VALUES
                        (1, 1, 'Donation of $1000 for charity event');",

                    // Create DonationManagement Table
                    "CREATE TABLE DonationManagement (
                        donation_management_id INT AUTO_INCREMENT PRIMARY KEY,
                        organization_id INT,
                        donation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        FOREIGN KEY (organization_id) REFERENCES Organization(id) ON DELETE CASCADE
                    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                    // Insert a single DonationManagement record
                    "INSERT INTO DonationManagement (organization_id) VALUES (1);",

                    // Create DonationTypes Table
                    "CREATE TABLE DonationTypes (
                        donation_type_id INT AUTO_INCREMENT PRIMARY KEY,
                        type_name VARCHAR(255) NOT NULL
                    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                    // Insert sample donation types
                    "INSERT INTO DonationTypes (type_name) VALUES 
                        ('Clothes'), 
                        ('Books');",

                    // Create DonationItem Table
                    "CREATE TABLE DonationItem (
                        donation_item_id INT AUTO_INCREMENT PRIMARY KEY,
                        donation_management_id INT,
                        donation_type_id INT,
                        description TEXT,
                        date_donated DATETIME,
                        FOREIGN KEY (donation_management_id) REFERENCES DonationManagement(donation_management_id),
                        FOREIGN KEY (donation_type_id) REFERENCES DonationTypes(donation_type_id)
                    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                    // Insert Donation Items
                    "INSERT INTO DonationItem (donation_management_id, donation_type_id, description, date_donated) VALUES
                        (1, 1, 'Donation of 20 winter jackets', '2024-11-01 12:00:00'),
                        (1, 2, 'Donation of 50 books for the children\'s library', '2024-11-01 12:00:00');",

                    // Create Address Table
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

                    // Create Event Table
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
                ], true
            );
            echo "Database populated successfully!";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
