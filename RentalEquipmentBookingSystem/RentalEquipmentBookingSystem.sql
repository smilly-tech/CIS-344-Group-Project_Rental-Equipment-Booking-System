-- Create database
CREATE DATABASE RentalEquipmentBookingSystem;
USE RentalEquipmentBookingSystem;

-- Users Table
CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Email VARCHAR(100) UNIQUE NOT NULL,
    PasswordHash VARCHAR(255) NOT NULL,
    PhoneNumber VARCHAR(15),
    Address VARCHAR(255),
    Role ENUM('Customer', 'Admin') DEFAULT 'Customer',
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO Users (FirstName, LastName, Email, PasswordHash, PhoneNumber, Address, Role)
VALUES 
('Tom', 'Holland', 'tom.holland@example.com', 'hashed_password1', '1112223333', '12 Spiderman Lane, Queens, NY', 'Customer'),
('Zendaya', 'Coleman', 'zendaya.coleman@example.com', 'hashed_password2', '2223334444', '34 Euphoria Blvd, Los Angeles, CA', 'Customer'),
('Chris', 'Hemsworth', 'chris.hemsworth@example.com', 'hashed_password3', '3334445555', '7 Thor Avenue, Sydney, Australia', 'Customer'),
('Scarlett', 'Johansson', 'scarlett.johansson@example.com', 'hashed_password4', '4445556666', '89 Widow Way, Manhattan, NY', 'Customer'),
('Dwayne', 'Johnson', 'dwayne.johnson@example.com', 'hashed_password5', '5556667777', '56 Rock Road, Hollywood, CA', 'Customer'),
('Emma', 'Watson', 'emma.watson@example.com', 'hashed_password6', '6667778888', '15 Hermione Street, London, UK', 'Customer'),
('Robert', 'Downey Jr.', 'robert.downey@example.com', 'hashed_password7', '7778889999', '22 Ironman Blvd, Malibu, CA', 'Admin'),
('Gal', 'Gadot', 'gal.gadot@example.com', 'hashed_password8', '8889990000', '98 Wonder Woman Street, Tel Aviv, Israel', 'Admin'),
('Ryan', 'Reynolds', 'ryan.reynolds@example.com', 'hashed_password9', '9990001111', '66 Deadpool Drive, Vancouver, Canada', 'Customer'),
('Jennifer', 'Lawrence', 'jennifer.lawrence@example.com', 'hashed_password10', '0001112222', '78 Hunger Games Avenue, Louisville, KY', 'Customer');

-- Equipment Table
CREATE TABLE Equipment (
    EquipmentID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Description TEXT,
    Category VARCHAR(50) NOT NULL,
    RentalRate DECIMAL(10, 2) NOT NULL,
    AvailabilityStatus ENUM('Available', 'Rented', 'Under Maintenance') DEFAULT 'Available',
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO Equipment (Name, Description, Category, RentalRate, AvailabilityStatus)
VALUES
('Canon DSLR Camera', 'Professional-grade camera for photography', 'Cameras', 25.00, 'Available'),
('Hammer Drill', 'Heavy-duty drill for construction work', 'Tools', 15.00, 'Available'),
('Tennis Racket', 'Standard tennis racket for sports', 'Sports Gear', 10.00, 'Available');

-- Rentals Table
CREATE TABLE Rentals (
    RentalID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT NOT NULL,
    EquipmentID INT NOT NULL,
    RentalDate DATETIME NOT NULL,
    ReturnDate DATETIME NULL,
    TotalAmount DECIMAL(10, 2) NOT NULL,
    RentalStatus ENUM('Pending', 'Completed', 'Canceled') DEFAULT 'Pending',
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (EquipmentID) REFERENCES Equipment(EquipmentID)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);
INSERT INTO Rentals (UserID, EquipmentID, RentalDate, ReturnDate, TotalAmount, RentalStatus)
VALUES
(1, 1, '2024-11-18 10:00:00', NULL, 75.00, 'Pending'), -- John rents the Canon DSLR Camera
(1, 2, '2024-11-19 15:00:00', '2024-11-20 15:00:00', 15.00, 'Completed'); -- John rents the Hammer Drill and returns it

-- Transactions Table
CREATE TABLE Transactions (
    TransactionID INT AUTO_INCREMENT PRIMARY KEY,
    RentalID INT NOT NULL,
    TransactionDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    AmountPaid DECIMAL(10, 2) NOT NULL,
    PaymentMethod ENUM('Credit Card', 'PayPal', 'Bank Transfer'),
    FOREIGN KEY (RentalID) REFERENCES Rentals(RentalID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
INSERT INTO Transactions (RentalID, TransactionDate, AmountPaid, PaymentMethod)
VALUES
(1, '2024-11-18 10:05:00', 75.00, 'Credit Card'), -- Payment for Canon DSLR Camera
(2, '2024-11-19 15:10:00', 15.00, 'PayPal'); -- Payment for Hammer Drill

-- Maintenance Table
CREATE TABLE Maintenance (
    MaintenanceID INT AUTO_INCREMENT PRIMARY KEY,
    EquipmentID INT NOT NULL,
    MaintenanceDate DATETIME NOT NULL,
    MaintenanceDetails TEXT NOT NULL,
    FOREIGN KEY (EquipmentID) REFERENCES Equipment(EquipmentID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
INSERT INTO Maintenance (EquipmentID, MaintenanceDate, MaintenanceDetails)
VALUES
(3, '2024-11-01 09:00:00', 'Replaced grip and strings'), -- Maintenance for Tennis Racket
(2, '2024-11-15 14:00:00', 'Checked and cleaned motor'); -- Maintenance for Hammer Drill

-- Selections
SELECT * FROM Users;
SELECT * FROM Equipment;
SELECT * FROM Rentals;
SELECT * FROM Transactions;
SELECT * FROM Maintenance;
-- Joins

SELECT 
    Rentals.RentalID, 
    Users.FirstName, 
    Users.LastName, 
    Equipment.Name AS EquipmentName, 
    Rentals.RentalDate, 
    Rentals.TotalAmount
FROM 
    Rentals
INNER JOIN 
    Users ON Rentals.UserID = Users.UserID
INNER JOIN 
    Equipment ON Rentals.EquipmentID = Equipment.EquipmentID;

SELECT 
    Users.FirstName, 
    Users.LastName, 
    Rentals.RentalID, 
    Rentals.RentalDate
FROM 
    Users
LEFT OUTER JOIN 
    Rentals ON Users.UserID = Rentals.UserID;

SELECT 
    Equipment.Name, 
    Rentals.RentalID, 
    Rentals.RentalStatus
FROM 
    Equipment
RIGHT OUTER JOIN 
    Rentals ON Equipment.EquipmentID = Rentals.EquipmentID;

-- Triggers
-- Ensures equipment availability (before a rental can be completed)
DELIMITER //
CREATE TRIGGER BeforeRentalInsert
BEFORE INSERT ON Rentals
FOR EACH ROW
BEGIN
    DECLARE equip_status ENUM('Available', 'Rented', 'Under Maintenance');
    SELECT AvailabilityStatus INTO equip_status FROM Equipment WHERE EquipmentID = NEW.EquipmentID;

    IF equip_status != 'Available' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'The equipment is not available for rental.';
    END IF;

    -- Mark equipment as rented
    UPDATE Equipment SET AvailabilityStatus = 'Rented' WHERE EquipmentID = NEW.EquipmentID;
END;
//
DELIMITER ;

-- Updates equipment availability (when a rental is completed or canceled)
DELIMITER //
CREATE TRIGGER AfterRentalUpdate
AFTER UPDATE ON Rentals
FOR EACH ROW
BEGIN
    IF NEW.RentalStatus = 'Completed' OR NEW.RentalStatus = 'Canceled' THEN
        UPDATE Equipment SET AvailabilityStatus = 'Available' WHERE EquipmentID = NEW.EquipmentID;
    END IF;
END;
//
DELIMITER ;
