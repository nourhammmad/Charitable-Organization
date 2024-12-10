
<?php

require_once $_SERVER['DOCUMENT_ROOT']."\Database.php";
 


 
class Populate {
    public static function populate() {
        Database::run_queries(
            [
                "SET FOREIGN_KEY_CHECKS = 0;",
                "DROP TABLE IF EXISTS donationtypes, address, books, Volunteer ,clothes, event, DonationLog,eventvolunteer, money, users, payments, donations, registeredusertype, events, tasks, donationitem, donationmanagement, donor
                , organization, ipayment, cash, visa, instapay,FoodBankEvent,FamilyShelterEvent,EducationalCenterEvent,EventTypes, VolunteerTaskAssignments, sms_logs;",
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
                    phone INT NOT NULL,
                    category ENUM('Volunteer', 'Donor'),
                    PRIMARY KEY (id),
                    FOREIGN KEY (id) REFERENCES Users(id) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
                // Insert sample RegisteredUserType
                "INSERT INTO RegisteredUserType (id, email, userName, passwordHash, category) VALUES
                    (1, 'john.doe@example.com', 'john_doe', 'hashedpassword1', 'Donor'),
                    (2, 'jane.smith@example.com', 'jane_smith', 'hashedpassword2', 'Volunteer');",
                    
 
                   " CREATE TABLE sms_logs (
                        id INTEGER PRIMARY KEY AUTO_INCREMENT,
                        sender_id INT NOT NULL,              -- References Users table
                        recipient_id INT NOT NULL,           -- References Users table
                        message TEXT NOT NULL,               -- The SMS message content
                        status TEXT DEFAULT 'pending',       -- Options: 'pending', 'sent', 'failed'
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp for the SMS
                        FOREIGN KEY (sender_id) REFERENCES RegisteredUserType(id) ON DELETE CASCADE,
                        FOREIGN KEY (recipient_id) REFERENCES RegisteredUserType(id) ON DELETE CASCADE
                    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                    
                // Create Organization Table
                "CREATE TABLE Organization (
                    id INT NOT NULL PRIMARY KEY,  
                    name VARCHAR(100) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
                // Insert into Organization
                "INSERT INTO Organization (id, name) VALUES
                    (1, 'My Charitable Organization');",
 



                // Continue with other tables...
                // Create Volunteer Table
                "CREATE TABLE Volunteer (
                    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    registered_user_id INT NOT NULL,  
                    organization_id INT,  
                    other_volunteer_specific_field VARCHAR(255),  
                    skills ENUM('Cooking', 'Teaching', 'Building') NOT NULL,
                    FOREIGN KEY (registered_user_id) REFERENCES RegisteredUserType(id) ON DELETE CASCADE,
                    FOREIGN KEY (organization_id) REFERENCES Organization(id) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
                // Insert into Volunteer Table
                "INSERT INTO Volunteer (registered_user_id, organization_id, other_volunteer_specific_field, skills) 
                    VALUES (2, 1, 'Event Coordinator', 'Cooking');
                    ",
                    


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
                    FOREIGN KEY (organization_id) REFERENCES Organization(id) ON DELETE CASCADE,
                    UNIQUE (organization_id)  
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
                // Insert a single DonationManagement record for the organization
                "INSERT INTO DonationManagement (organization_id) VALUES
                    (1);",
 
                // Create DonationTypes Table (Parent Table)
                "CREATE TABLE DonationTypes (
                    donation_type_id INT AUTO_INCREMENT PRIMARY KEY,
                    type_name ENUM('Money', 'Books', 'Clothes') NOT NULL
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",





                "CREATE TABLE VolunteerTaskAssignments (
                    volunteerId INT NOT NULL,
                    taskId INT NOT NULL,
                    assignedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (volunteerId, taskId),
                    FOREIGN KEY (volunteerId) REFERENCES Volunteer(id) ON DELETE CASCADE,
                    FOREIGN KEY (taskId) REFERENCES Tasks(id) ON DELETE CASCADE);",

                // Insert DonationTypes (Money, Books, Clothes)
                "INSERT INTO DonationTypes (type_name) VALUES
                    ('Money'),
                    ('Books'),
                    ('Clothes');",

                // Create Money Table (Child Table)
                "CREATE TABLE Money (
                    money_id INT AUTO_INCREMENT PRIMARY KEY,
                    donation_type_id INT,
                    donation_management_id INT,
                    amount DECIMAL(10, 2) NOT NULL,
                    currency VARCHAR(10) DEFAULT 'USD',
                    date_donated DATETIME,
                    FOREIGN KEY (donation_type_id) REFERENCES DonationTypes(donation_type_id) ON DELETE CASCADE,
                    FOREIGN KEY (donation_management_id) REFERENCES DonationManagement(donation_management_id) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
 
                // Insert Money Donation
                "INSERT INTO Money (donation_type_id, donation_management_id, amount, currency, date_donated) VALUES
                    (1, 1, 1000.00, 'USD', '2024-11-01 12:00:00');",


                // Create Payments Table to Reference Payment Types
                "CREATE TABLE Payments (
                    payment_id INT AUTO_INCREMENT PRIMARY KEY,
                    donor_id INT,
                    money_id INT,
                    amount DECIMAL(10, 2) NOT NULL,
                    payment_method ENUM('Cash', 'Visa', 'Instapay') NOT NULL,
                    FOREIGN KEY (donor_id) REFERENCES Donor(id) ON DELETE CASCADE,
                    FOREIGN KEY (money_id) REFERENCES Money(money_id) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                // Insert Payments without status
                "INSERT INTO Payments (donor_id, money_id, amount, payment_method) VALUES
                    (1, 1, 500.00, 'Cash'),
                    (1, 1, 200.00, 'Visa'),
                    (1, 1, 300.00, 'Instapay');",
                // Create Cash Table (Specific Fields for Cash Payments)
                "CREATE TABLE Cash (
                    payment_id INT NOT NULL,
                    transaction_id VARCHAR(100) UNIQUE,
                    FOREIGN KEY (payment_id) REFERENCES Payments(payment_id) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                // Create Visa Table (Specific Fields for Visa Payments)
                "CREATE TABLE Visa (
                    payment_id INT NOT NULL,
                    transaction_number VARCHAR(100) UNIQUE,
                    card_number VARCHAR(50),
                    FOREIGN KEY (payment_id) REFERENCES Payments(payment_id) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                // Create Instapay Table (Specific Fields for Instapay Payments)
                "CREATE TABLE Instapay (
                    payment_id INT NOT NULL,
                    transaction_reference VARCHAR(100) UNIQUE,
                    account_number VARCHAR(50),
                    FOREIGN KEY (payment_id) REFERENCES Payments(payment_id) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                // Insert into specific payment tables
                "INSERT INTO Cash (payment_id, transaction_id) VALUES
                    (1, 'CASH12345');",
                
                "INSERT INTO Visa (payment_id, transaction_number, card_number) VALUES
                    (2, 'VISA67890', '1234-5678-9876-5432');",
                
                "INSERT INTO Instapay (payment_id, transaction_reference, account_number) VALUES
                    (3, 'INSTA54321', '1234567890');",  
 
                // Create Books Table (Child Table)
                "CREATE TABLE Books (
                    book_id INT AUTO_INCREMENT PRIMARY KEY,
                    donation_type_id INT,
                    donation_management_id INT,
                    book_title VARCHAR(255),
                    author VARCHAR(255),
                    publication_year INT,
                    quantity INT,
                    date_donated DATETIME,
                    FOREIGN KEY (donation_type_id) REFERENCES DonationTypes(donation_type_id) ON DELETE CASCADE,
                    FOREIGN KEY (donation_management_id) REFERENCES DonationManagement(donation_management_id) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                // Insert Books Donation
                "INSERT INTO Books (donation_type_id, donation_management_id, book_title, author, publication_year, quantity, date_donated) VALUES
                    (2, 1, 'The Great Gatsby', 'F. Scott Fitzgerald', 1925, 10, '2024-11-01 12:00:00');",

                // Create Clothes Table (Child Table)
                "CREATE TABLE Clothes (
                    clothes_id INT AUTO_INCREMENT PRIMARY KEY,
                    donation_type_id INT,
                    donation_management_id INT,
                    clothes_type VARCHAR(100),
                    size VARCHAR(50),
                    color VARCHAR(50),
                    quantity INT,
                    date_donated DATETIME,
                    FOREIGN KEY (donation_type_id) REFERENCES DonationTypes(donation_type_id) ON DELETE CASCADE,
                    FOREIGN KEY (donation_management_id) REFERENCES DonationManagement(donation_management_id) ON DELETE CASCADE
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                // Insert Clothes Donation
                "INSERT INTO Clothes (donation_type_id, donation_management_id, clothes_type, size, color, quantity, date_donated) VALUES
                    (3, 1, 'Winter Jacket', 'L', 'Red', 20, '2024-11-01 12:00:00');",

                // Create DonationItem Table
                "CREATE TABLE DonationItem (
                    donation_item_id INT AUTO_INCREMENT PRIMARY KEY,
                    donation_management_id INT,
                    donation_type_id INT,
                    description TEXT,
                    date_donated DATETIME,
                    FOREIGN KEY (donation_management_id) REFERENCES DonationManagement(donation_management_id) ON DELETE CASCADE,
                    FOREIGN KEY (donation_type_id) REFERENCES DonationTypes(donation_type_id)
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

                // Insert data into DonationItem table
                "INSERT INTO DonationItem (donation_management_id, donation_type_id, description, date_donated) VALUES
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

                    //create table logs for the history of donations 
                   
 
                    // Insert sample address
                    "INSERT INTO Address (addressId, street, floor, apartment, city) VALUES
                        ('hkhk', '123 Main St', 5, 101, 'New York');",

                     "CREATE TABLE EventTypes (
                        event_type_id INT AUTO_INCREMENT PRIMARY KEY,
                        type_name ENUM('FoodBank', 'FamilyShelters', 'EducationalCenters') NOT NULL
                    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",


                    "INSERT INTO EventTypes (type_name) VALUES
                            ('FoodBank'),
                            ('FamilyShelters'),
                            ('EducationalCenters');",     
                    

                "CREATE TABLE Event (
                        eventId INT AUTO_INCREMENT PRIMARY KEY,
                        eventName VARCHAR(255) NOT NULL,
                        date DATE NOT NULL,
                        addressId CHAR(36),
                        EventAttendanceCapacity INT NOT NULL,
                        tickets INT,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        event_type_id INT NOT NULL,
                        FOREIGN KEY (addressId) REFERENCES Address(addressId),
                        FOREIGN KEY (event_type_id) REFERENCES EventTypes(event_type_id)
                    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT = 1;",

// "INSERT INTO Event (date, addressId, EventAttendanceCapacity, tickets, event_type_id) VALUES
//                     ('2024-12-01', 'hkhk', 200, 150, 1), 
//                     ('2024-12-15', 'hkhk', 300, 250, 2); 
// ", 
                   
                   "CREATE TABLE FoodBankEvent (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    eventId INT,
                    foodQuantity INT,
                    foodType VARCHAR(255),
                    foodBankLocation VARCHAR(255),
                    AccessLevel INT DEFAULT 0,
                    event_type_id INT,
                    FOREIGN KEY (event_type_id) REFERENCES EventTypes(event_type_id),
                    FOREIGN KEY (eventId) REFERENCES Event(eventId));",                   

                    "CREATE TABLE FamilyShelterEvent (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        eventId INT,
                        numberOfShelters INT,
                        shelterLocation VARCHAR(255),
                        capacity INT,
                        AccessLevel INT DEFAULT 0,
                        event_type_id INT,
                        FOREIGN KEY (event_type_id) REFERENCES EventTypes(event_type_id),
                        FOREIGN KEY (eventId) REFERENCES Event(eventId));",

                    "CREATE TABLE EducationalCenterEvent (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            eventId INT,
                            numberOfCenters INT,
                            centerLocation VARCHAR(255),
                            AccessLevel INT DEFAULT 0,
                            event_type_id INT,
                            FOREIGN KEY (event_type_id) REFERENCES EventTypes(event_type_id),
                            FOREIGN KEY (eventId) REFERENCES Event(eventId));",                        

            // "INSERT INTO FoodBankEvent (eventId, foodQuantity, foodType, foodBankLocation, event_type_id) VALUES
            // (1, 500, 'Canned Goods', 'Downtown Food Bank', 1);",

            // "INSERT INTO FamilyShelterEvent (eventId, numberOfShelters, shelterLocation, capacity, facilities, event_type_id) VALUES
            // (2, 10, 'Northside Family Shelter', 50, 'Restrooms, Showers, Sleeping Areas', 2);",
 
                    // Create EventVolunteer Table to link Events and Volunteers
                    
                    "CREATE TABLE EventVolunteer (
                        eventId INT,
                        volunteerId INT,
                        PRIMARY KEY (eventId, volunteerId),
                        FOREIGN KEY (eventId) REFERENCES Event(eventId) ON DELETE CASCADE,
                        FOREIGN KEY (volunteerId) REFERENCES Volunteer(id) ON DELETE CASCADE
                    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                    "CREATE TABLE DonationLog (
                        log_id INT AUTO_INCREMENT PRIMARY KEY,
                        donorId INT NOT NULL,
                        organization_id INT,
                        donation_item_id INT,
                        donation_type_id INT,
                        previous_state ENUM('CREATE','DELETE'),
                        current_state ENUM('CREATE', 'DELETE'), 
                        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        FOREIGN KEY (donation_type_id) REFERENCES DonationTypes(donation_type_id) ON DELETE CASCADE,
                        FOREIGN KEY (donorId) REFERENCES RegisteredUserType(id) ON DELETE CASCADE,
                        FOREIGN KEY (organization_id) REFERENCES Organization(id) ON DELETE CASCADE,
                        FOREIGN KEY (donation_item_id) REFERENCES DonationItem(donation_item_id) ON DELETE CASCADE
                    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                   
                    // Insert a Volunteer association with the Event
                    // "INSERT INTO EventVolunteer (eventId, volunteerId) VALUES
                    //     (1, 1);",

// "INSERT INTO EventVolunteer (eventId, volunteerId) VALUES
// (1, 1);",
  "INSERT INTO Event (eventName, date, addressId, EventAttendanceCapacity, tickets,event_type_id ) VALUES
  ('Winter Coat Drive', '2024-12-05', (SELECT addressId FROM Address LIMIT 1), 150, 75,1 ),
  ('Book Donation Fair', '2024-12-10', (SELECT addressId FROM Address LIMIT 1), 200, 100, 3),
  ('Toy Giveaway', '2024-12-15', (SELECT addressId FROM Address LIMIT 1), 250, 125, 2),
  ('Soup Kitchen Volunteer Day', '2024-12-20', (SELECT addressId FROM Address LIMIT 1), 80, 40, 1);",


"INSERT INTO Tasks (name, description, requiredSkill, timeSlot, location)
VALUES 
('Donation Sorting', 'Organizing and categorizing donated items such as clothes, toys, and food', 'Organization Skills', '9:00 AM - 12:00 PM', 'Charity Warehouse'),
('Volunteer Coordination', 'Supervising and guiding volunteers during a food drive', 'Leadership', '10:00 AM - 2:00 PM', 'Community Center'),
('Event Promotion', 'Distributing flyers and promoting the charity event on social media', 'Marketing Skills', '10:00 AM - 1:00 PM', 'Office'),
('Food Packing', 'Packing food items for distribution to families in need', 'Attention to Detail', '1:00 PM - 4:00 PM', 'Charity Kitchen'),
('Cleanup Crew', 'Cleaning up after the charity gala event', 'Teamwork', '8:00 PM - 9:30 PM', 'Banquet Hall');"



            ]
);
}
}
?>