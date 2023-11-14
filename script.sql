-- create tables

CREATE TABLE Animal ( 
petID INTEGER, 
animalName VARCHAR,  
type VARCHAR,
age INTEGER, 
favouriteCaretaker INTEGER, 
previousOwner INTEGER, 
timeInShelter INTEGER, 
adopterID INTEGER, 
PRIMARY KEY (petID)
FOREIGN KEY (favouriteCaretaker) REFERENCES AnimalCaretaker(caretakerID), FOREIGN KEY (previousOwner) REFERENCES Customer(customerID), 
FOREIGN KEY (adopterID) REFERENCES Adopter(adopterID);

CREATE TABLE VetAppointment ( 
vetDate DATE, 
vetTime TIME, 
vetLicenseID INTEGER, 
reason VARCHAR, 
petID INTEGER,
PRIMARY KEY (vetDate, vetTime),
FOREIGN KEY (petID) REFERENCES Animal(petID));


CREATE TABLE Vet ( 
vetLicenseID INTEGER,
vetName VARCHAR
PRIMARY KEY (vetLicenseID));

CREATE TABLE AnimalCaretakers ( 
caretakerID INTEGER, 
caretakerName VARCHAR, 
fundEventID INTEGER, 
caretakerAddress VARCHAR, 
caretakerPostalCode VARCHAR,
PRIMARY KEY (caretakerID) 
FOREIGN KEY (fundEventID) REFERENCES FundraiserEvent(eventID));

CREATE TABLE AnimalCaretakerPC ( 
caretakerPostalCode VARCHAR, 
caretakerCity VARCHAR
PRIMARY KEY (caretakerPostalCode));

CREATE TABLE Worker ( 
workerID INTEGER, 
hourlyPay INTEGER,
PRIMARY KEY (workerID) 
FOREIGN KEY (workerID) REFERENCES AnimalCaretaker(caretakerID));

CREATE TABLE Volunteer ( 
volunteerID INTEGER, 
hoursVolunteered INTEGER, 
PRIMARY KEY (volunteerID),
FOREIGN KEY (volunteerID) REFERENCES AnimalCaretaker(caretakerID));

CREATE TABLE FundraiserEvent ( 
eventID INTEGER, 
eventType VARCHAR, 
eventDate DATE, 
eventTime TIME,
donationGoal INTEGER,
PRIMARY KEY (eventID),
UNIQUE (eventDate));

	CREATE TABLE FundraiserEventDate ( 
eventDate DATE, 
eventTime TIME,
PRIMARY KEY (eventDate),
UNIQUE (eventDate));

CREATE TABLE Post ( 
postID INTEGER, 
postType VARCHAR, 
description VARCHAR, 
postingDate DATE, 
caretakerID INTEGER, 
PRIMARY KEY (postID),
FOREIGN KEY (caretakerID) REFERENCES AnimalCaretaker(caretakerID),
UNIQUE(postingDate));

CREATE TABLE PostDateAndType ( 
	postingDate DATE, 
postType VARCHAR, 
PRIMARY KEY (postingDate),
UNIQUE(postingDate));

CREATE TABLE Customer ( 
customerID INTEGER, 
customerName VARCHAR,
PRIMARY KEY (customerID));

CREATE TABLE Adopter ( 
adopterID INTEGER, 
numOfAdoptions INTEGER, 
safeOwnerRating INTEGER,
adopterPostalCode VARCHAR, 
adopterAddress VARCHAR, 
PRIMARY KEY (adopterID)
FOREIGN KEY (adopterID) REFERENCES Customer(customerID));

CREATE TABLE AdopterPCs ( 
adopterPostalCode VARCHAR, 
adopterCity VARCHAR, 
PRIMARY KEY (adopterPostalCode));

CREATE TABLE AdoptionDetails ( 
adoptionID INTEGER, 
petID INTEGER UNIQUE, 
adopterID INTEGER, 
caretakerID INTEGER, 
adoptionDate DATE, 
notes VARCHAR, 
PRIMARY KEY (adoptionID)
FOREIGN KEY (petID) REFERENCES Animal(petID), 
FOREIGN KEY (adopterID) REFERENCES Adopter(adopterID), 
FOREIGN KEY (caretakerID) REFERENCES AnimalCaretaker(caretakerID));

CREATE TABLE PetAdopter ( 
petID INTEGER, 
adopterID INTEGER, 
PRIMARY KEY (petID)
FOREIGN KEY (petID) REFERENCES Animal(petID), 
FOREIGN KEY (adopterID) REFERENCES Adopter(adopterID);

CREATE TABLE Appointment ( 
petID INTEGER, 
caretakerID INTEGER, 
customerID INTEGER, 
apptDate DATE, 
apptTime TIME, 
PRIMARY KEY (petID, caretakerID, customerID), 
FOREIGN KEY (petID) REFERENCES Animal(petID), 
FOREIGN KEY (caretakerID) REFERENCES AnimalCaretaker(caretakerID),
FOREIGN KEY (customerID) REFERENCES Customer(customerID));

CREATE TABLE Donation ( 
customerID INTEGER, 
caretakerID INTEGER, 
amount INTEGER, 
PRIMARY KEY (customerID, caretakerID), 
FOREIGN KEY (customerID) REFERENCES Customer(customerID), 
FOREIGN KEY (caretakerID) REFERENCES AnimalCaretaker(caretakerID));

CREATE TABLE Item ( 
itemID INTEGER, 
itemName VARCHAR, 
quantity INTEGER,
PRIMARY KEY (itemID));

CREATE TABLE ItemPurchase (
customerID INTEGER, 
caretakerID INTEGER, 
itemID INTEGER,
PRIMARY KEY (customerID, caretakerID, itemID), 
FOREIGN KEY (customerID) REFERENCES Customer(customerID), 
FOREIGN KEY (caretakerID) REFERENCES AnimalCaretaker(caretakerID), FOREIGN KEY (itemID) REFERENCES Item(itemID));
	
CREATE TABLE ItemPrice (
itemID INTEGER, 
total INTEGER, 
PRIMARY KEY (itemID);

-- insert data

INSERT INTO Animal (petID, animalName, type, age, favouriteCaretaker, previousOwner, timeInShelter, adopterID) 
VALUES
(1, 'Fluffy', 'Cat', 2, 3, 4, 12, 1), 
(2, 'Rex', 'Dog', 3, 1, 4, 10, 2), 
(3, 'Whiskers', 'Cat', 5, 2, 5, 8, 3), 
(4, 'Buddy', 'Bunny', 4, 4, 3, 9, 4), 
(5, 'Luna', 'Dog', 1, 3, 1, 11, 5),
(6, 'Domino', 'Hamster', 1, 3, 1, 2, NULL),
(7, 'Patch', 'Dog', 2, 5, 4, 2, NULL),
(8, 'Pirate', 'Cat', 2, 4, 4, 11, NULL),
(9, 'Cloudy', 'Bunny', 3, 2, NULL, 7, NULL),
(10, 'Smoothie', 'Bunny', 3, 2, NULL, 7, NULL);

INSERT INTO VetAppointment (vetDate, vetTime, vetLicenseID, reason, petID) 
VALUES
('2023-10-20', '14:00:00', 1, 'Checkup', 1), 
('2023-10-21', '10:30:00', 2, 'Vaccination', 2), 
('2023-10-22', '15:15:00', 3, 'Dental cleaning', 3), 
('2023-10-23', '11:00:00', 4, 'Spaying', 4), 
('2023-10-24', '13:45:00', 5, 'Checkup', 5);

INSERT INTO Vet (vetLicenseID, vetName) 
VALUES 
(1, 'Dr. Allan'), 
(2, 'Dr. Papper'), 
(3, 'Dr. Lorde'), 
(4, 'Dr. Levette'), 
(5, 'Dr. Michaels');

INSERT INTO AnimalCaretakers (caretakerID, caretakerName, fundEventID, caretakerAddress, caretakerPostalCode) 
VALUES 
(1, 'John Peters', 1, '123 Main St', '12345'), 
(2, 'Mary Johnson', 2, '456 Elm St', '67890'), 
(3, 'David Perks', 3, '789 Oak St', '34567'), 
(4, 'Elaine Brown', 4, '101 Pine St', '87654'), 
(5, 'Michael Wilson', 5, '234 Maple St', '43210');

INSERT INTO AnimalCaretakerPC (caretakerPostalCode, caretakerCity) 
VALUES 
('12345', 'Narnia'), 
('67890', 'Atlantis'), 
('34567', 'Brokeburn'), 
('87654', 'Lancaster'),
('43210', 'Columbus');

INSERT INTO Worker (workerID, hourlyPay) 
VALUES 
(1, 15), 
(2, 17),
(3, 14), 
(4, 18), 
(5, 16);

INSERT INTO Volunteer (volunteerID, hoursVolunteered) 
VALUES 
(1, 20), 
(2, 25), 
(3, 18), 
(4, 30), 
(5, 22); 

INSERT INTO FundraiserEvent (eventID, eventType, eventDate, eventTime, donationGoal) VALUES 
(1, 'Charity Auction', '2023-11-01', '18:00:00', 5000), 
(2, 'Pet Walkathon', '2023-11-15', '10:00:00', 3000), 
(3, 'Adoption Fair', '2023-11-30', '14:30:00', 2000), 
(4, 'Pet Costume Contest', '2023-12-10', '15:00:00', 2500), 
(5, 'Animal Rescue Gala', '2023-12-25', '19:00:00', 7000);

INSERT INTO FundraiserEventDate (eventDate, eventTime) 
VALUES 
('2023-10-20', '18:00:00'), 
('2023-10-21', '19:30:00'), 
('2023-10-22', '17:45:00'), 
('2023-10-23', '20:15:00'), 
('2023-10-24', '09:00:00');

INSERT INTO Post (postID, postType, description, postingDate, caretakerID) 
VALUES 
(1, 'Announcement', 'Adoption event this weekend!', '2023-10-25', 101), 
(2, 'News', 'New arrivals in the shelter', '2023-10-26', 102), 
(3, 'Update', 'Vet check-ups for all animals', '2023-10-27', 103), 
(4, 'Event', 'Volunteer appreciation day', '2023-10-28', 104), 
(5, 'Adoption', 'Adopt a furry friend today', '2023-10-29', 105);

INSERT INTO PostDateAndType (postingDate, postType) 
VALUES 
('2023-10-25', 'Announcement'), 
('2023-10-26', 'News'), 
('2023-10-27', 'Update'), 
('2023-10-28', 'Event'), 
('2023-10-29', 'Adoption');

INSERT INTO Customer (customerID, customerName) 
VALUES 
(1, 'Alice Johnson'), 
(2, 'Bob Smith'), 
(3, 'Carol Davis'), 
(4, 'David Wilson'),
(5, 'Eve Brown'); 

INSERT INTO Adopter (adopterID, numOfAdoptions, safeOwnerRating, adopterPostalCode, adopterAddress) 
VALUES 
(1, 2, 4, '12345', '123 Elm St'), 
(2, 0, 3, '23456', '456 Oak St'), 
(3, 1, 5, '34567', '789 Pine St'),
(4, 3, 4, '45678', '101 Maple St'),
(5, 2, 4, '56789', '234 Birch St');

INSERT INTO AdopterPCs (adopterPostalCode, adopterCity) 
VALUES 
('12345', 'Narnia'), 
('23456', 'Atlantis'), 
('34567', 'Brokeburn'), 
('45678', 'Lancaster'), 
('56789', 'Columbus');

INSERT INTO AdoptionDetails (adoptionID, petID, adopterID, caretakerID, adoptionDate, notes) 
VALUES 
(1, 1, 1, 1, '2023-10-20', 'friendly cat'), 
(2, 2, 2, 2, '2023-10-21', 'playful dog'), 
(3, 3, 3, 3, '2023-10-22', 'loud cat'),
(4, 4, 4, 4, '2023-10-23', 'really soft bunny'), 
(5, 5, 5, 5, '2023-10-24', 'quiet dog');

INSERT INTO PetAdopter (petID, adopterID) 
VALUES 
(1, 1), 
(2, 2), 
(3, 3), 
(4, 4), 
(5, 5);

INSERT INTO Donation (customerID, caretakerID, amount) 
VALUES 
(1, 1, 100), 
(2, 2, 150),
(3, 3, 200), 
(4, 4, 50), 
(5, 5, 75);

INSERT INTO Item (itemID, itemName, quantity) 
VALUES 
(1, 'Pet Food', 100), 
(2, 'Blankets', 50), 
(3, 'Toys', 75), 
(4, 'Medicine', 25), 
(5, 'Leashes', 30);

INSERT INTO ItemPurchase (customerID, caretakerID, itemID) 
VALUES 
(1, 1, 3), 
(2, 1, 5), 
(3, 3, 1), 
(4, 5, 4), 
(5, 3, 5);

INSERT INTO ItemPrice (itemID, total) 
VALUES 
(5, 200), 
(2, 100), 
(1, 150), 
(4, 75), 
(3, 90);

