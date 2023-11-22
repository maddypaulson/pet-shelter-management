CREATE TABLE FundraiserEvent (eventID INTEGER, eventType VARCHAR2(255), eventDate DATE, eventTime TIME,donationGoal INTEGER,PRIMARY KEY (eventID), UNIQUE (eventDate));

CREATE TABLE FundraiserEventDate (eventDate DATE, eventTime TIME,PRIMARY KEY (eventDate),UNIQUE (eventDate));

CREATE TABLE AnimalCaretaker (caretakerID INTEGER, caretakerName VARCHAR2, fundEventID INTEGER, caretakerAddress VARCHAR2, caretakerPostalCode VARCHAR2, PRIMARY KEY (caretakerID), FOREIGN KEY (fundEventID) REFERENCES FundraiserEvent(eventID));

CREATE TABLE Customer (customerID INTEGER, customerName VARCHAR2, PRIMARY KEY (customerID));

CREATE TABLE Adopter (adopterID INTEGER, numOfAdoptions INTEGER, safeOwnerRating INTEGER,adopterPostalCode VARCHAR2, adopterAddress VARCHAR2, PRIMARY KEY (adopterID), FOREIGN KEY (adopterID) REFERENCES Customer(customerID));

CREATE TABLE Animal (petID INTEGER, animalName VARCHAR2,  type VARCHAR2,age INTEGER, favouriteCaretaker INTEGER, previousOwner INTEGER, timeInShelter INTEGER, adopterID INTEGER, PRIMARY KEY (petID), FOREIGN KEY (favouriteCaretaker) REFERENCES AnimalCaretaker(caretakerID), FOREIGN KEY (previousOwner) REFERENCES Customer(customerID), FOREIGN KEY (adopterID) REFERENCES Adopter(adopterID));

CREATE TABLE VetAppointment (vetDate DATE, vetTime TIME, vetLicenseID INTEGER, reason VARCHAR2, petID INTEGER, PRIMARY KEY (vetDate, vetTime), FOREIGN KEY (petID) REFERENCES Animal(petID));

CREATE TABLE Worker (workerID INTEGER, hourlyPay INTEGER, PRIMARY KEY (workerID), FOREIGN KEY (workerID) REFERENCES AnimalCaretaker(caretakerID));

CREATE TABLE Volunteer (volunteerID INTEGER, hoursVolunteered INTEGER, PRIMARY KEY (volunteerID), FOREIGN KEY (volunteerID) REFERENCES AnimalCaretaker(caretakerID));

CREATE TABLE Post (postID INTEGER, postType VARCHAR2, description VARCHAR2, postingDate DATE, caretakerID INTEGER, PRIMARY KEY (postID), FOREIGN KEY (caretakerID) REFERENCES AnimalCaretaker(caretakerID), UNIQUE(postingDate));

CREATE TABLE AdoptionDetails (adoptionID INTEGER, petID INTEGER UNIQUE, adopterID INTEGER, caretakerID INTEGER, adoptionDate DATE, notes VARCHAR2, PRIMARY KEY (adoptionID), FOREIGN KEY (petID) REFERENCES Animal(petID), FOREIGN KEY (adopterID) REFERENCES Adopter(adopterID), FOREIGN KEY (caretakerID) REFERENCES AnimalCaretaker(caretakerID));

CREATE TABLE PetAdopter (petID INTEGER, adopterID INTEGER, PRIMARY KEY (petID), FOREIGN KEY (petID) REFERENCES Animal(petID), FOREIGN KEY (adopterID) REFERENCES Adopter(adopterID));

CREATE TABLE Appointment (petID INTEGER, caretakerID INTEGER, customerID INTEGER, apptDate DATE, apptTime TIME, PRIMARY KEY (petID, caretakerID, customerID), FOREIGN KEY (petID) REFERENCES Animal(petID), FOREIGN KEY (caretakerID) REFERENCES AnimalCaretaker(caretakerID), FOREIGN KEY (customerID) REFERENCES Customer(customerID));

CREATE TABLE Donation (customerID INTEGER, caretakerID INTEGER, amount INTEGER, PRIMARY KEY (customerID, caretakerID), FOREIGN KEY (customerID) REFERENCES Customer(customerID), FOREIGN KEY (caretakerID) REFERENCES AnimalCaretaker(caretakerID));

CREATE TABLE Item (itemID INTEGER, itemName VARCHAR2, quantity INTEGER, PRIMARY KEY (itemID));

CREATE TABLE ItemPurchase (customerID INTEGER, caretakerID INTEGER, itemID INTEGER, PRIMARY KEY (customerID, caretakerID, itemID), FOREIGN KEY (customerID) REFERENCES Customer(customerID), FOREIGN KEY (caretakerID) REFERENCES AnimalCaretaker(caretakerID), FOREIGN KEY (itemID) REFERENCES Item(itemID));

CREATE TABLE Vet (vetLicenseID INTEGER, vetName VARCHAR2, PRIMARY KEY (vetLicenseID));

CREATE TABLE AnimalCaretakerPC (caretakerPostalCode VARCHAR2, caretakerCity VARCHAR2, PRIMARY KEY (caretakerPostalCode));

CREATE TABLE PostDateAndType (postingDate DATE, postType VARCHAR2, PRIMARY KEY (postingDate), UNIQUE(postingDate));

CREATE TABLE AdopterPCs (adopterPostalCode VARCHAR2, adopterCity VARCHAR2, PRIMARY KEY (adopterPostalCode));

CREATE TABLE ItemPrice (itemID INTEGER, total INTEGER, PRIMARY KEY (itemID));

INSERT INTO FundraiserEvent (eventID, eventType, eventDate, eventTime, donationGoal) VALUES (1, 'Charity Auction', '2023-11-01', '18:00:00', 5000);
INSERT INTO FundraiserEvent (eventID, eventType, eventDate, eventTime, donationGoal) VALUES (2, 'Pet Walkathon', '2023-11-15', '10:00:00', 3000); 
INSERT INTO FundraiserEvent (eventID, eventType, eventDate, eventTime, donationGoal) VALUES (3, 'Adoption Fair', '2023-11-30', '14:30:00', 2000);
INSERT INTO FundraiserEvent (eventID, eventType, eventDate, eventTime, donationGoal) VALUES (4, 'Pet Costume Contest', '2023-12-10', '15:00:00', 2500); 
INSERT INTO FundraiserEvent (eventID, eventType, eventDate, eventTime, donationGoal) VALUES (5, 'Animal Rescue Gala', '2023-12-25', '19:00:00', 7000);

INSERT INTO FundraiserEventDate (eventDate, eventTime) VALUES ('2023-10-20', '18:00:00’);
INSERT INTO FundraiserEventDate (eventDate, eventTime) VALUES ('2023-10-21', '19:30:00’);
INSERT INTO FundraiserEventDate (eventDate, eventTime) VALUES ('2023-10-22', '17:45:00’); 
INSERT INTO FundraiserEventDate (eventDate, eventTime) VALUES ('2023-10-23', '20:15:00’); 
INSERT INTO FundraiserEventDate (eventDate, eventTime) VALUES ('2023-10-24', '09:00:00');

INSERT INTO AnimalCaretaker (caretakerID, caretakerName, fundEventID, caretakerAddress, caretakerPostalCode) VALUES (1, 'John Peters', 1, '123 Main St', '12345’);
INSERT INTO AnimalCaretaker (caretakerID, caretakerName, fundEventID, caretakerAddress, caretakerPostalCode) VALUES (2, 'Mary Johnson', 2, '456 Elm St', '67890’); 
INSERT INTO AnimalCaretaker (caretakerID, caretakerName, fundEventID, caretakerAddress, caretakerPostalCode) VALUES (3, 'David Perks', 3, '789 Oak St', '34567’);
INSERT INTO AnimalCaretaker (caretakerID, caretakerName, fundEventID, caretakerAddress, caretakerPostalCode) VALUES (4, 'Elaine Brown', 4, '101 Pine St', '87654’); 
INSERT INTO AnimalCaretaker (caretakerID, caretakerName, fundEventID, caretakerAddress, caretakerPostalCode) VALUES (5, 'Michael Wilson', 5, '234 Maple St', '43210');
INSERT INTO AnimalCaretaker (caretakerID, caretakerName, fundEventID, caretakerAddress, caretakerPostalCode) VALUES (6, 'Emily Anderson’, NULL, '123 Oak Lane’, '12345’);
INSERT INTO AnimalCaretaker (caretakerID, caretakerName, fundEventID, caretakerAddress, caretakerPostalCode) VALUES (7, 'Chris Martinez’, NULL, ’789 Pine St', '43210');
INSERT INTO AnimalCaretaker (caretakerID, caretakerName, fundEventID, caretakerAddress, caretakerPostalCode) VALUES (8, 'Jasmine Walker’, NULL, '101 Maple St', '34567');
INSERT INTO AnimalCaretaker (caretakerID, caretakerName, fundEventID, caretakerAddress, caretakerPostalCode) VALUES (9, 'Ryan Turner’, NULL, '201 Cedar Drive’, '43210');
INSERT INTO AnimalCaretaker (caretakerID, caretakerName, fundEventID, caretakerAddress, caretakerPostalCode) VALUES (10, 'Morgan Foster’, NULL, '234 Birch Blvd’, '67890');

INSERT INTO Customer (customerID, customerName) VALUES (1, 'Alice Johnson’); 
INSERT INTO Customer (customerID, customerName) VALUES (2, 'Bob Smith’);
INSERT INTO Customer (customerID, customerName) VALUES (3, 'Carol Davis’);
INSERT INTO Customer (customerID, customerName) VALUES (4, 'David Wilson’);
INSERT INTO Customer (customerID, customerName) VALUES (5, 'Eve Brown'); 

INSERT INTO Adopter (adopterID, numOfAdoptions, safeOwnerRating, adopterPostalCode, adopterAddress) VALUES (1, 2, 4, '12345', '123 Elm St’);
INSERT INTO Adopter (adopterID, numOfAdoptions, safeOwnerRating, adopterPostalCode, adopterAddress) VALUES (2, 0, 3, '23456', '456 Oak St’); 
INSERT INTO Adopter (adopterID, numOfAdoptions, safeOwnerRating, adopterPostalCode, adopterAddress) VALUES (3, 1, 5, '34567', '789 Pine St’);
INSERT INTO Adopter (adopterID, numOfAdoptions, safeOwnerRating, adopterPostalCode, adopterAddress) VALUES (4, 3, 4, '45678', '101 Maple St’);
INSERT INTO Adopter (adopterID, numOfAdoptions, safeOwnerRating, adopterPostalCode, adopterAddress) VALUES (5, 2, 4, '56789', '234 Birch St');

INSERT INTO Animal (petID, animalName, type, age, favouriteCaretaker, previousOwner, timeInShelter, adopterID) VALUES (1, 'Fluffy', 'Cat', 2, 3, 4, 12, 1);
INSERT INTO Animal (petID, animalName, type, age, favouriteCaretaker, previousOwner, timeInShelter, adopterID) VALUES (2, 'Rex', 'Dog', 3, 1, 4, 10, 2);
INSERT INTO Animal (petID, animalName, type, age, favouriteCaretaker, previousOwner, timeInShelter, adopterID) VALUES (3, 'Whiskers', 'Cat', 5, 2, 5, 8, 3);
INSERT INTO Animal (petID, animalName, type, age, favouriteCaretaker, previousOwner, timeInShelter, adopterID) VALUES (4, 'Buddy', 'Bunny', 4, 4, 3, 9, 4);
INSERT INTO Animal (petID, animalName, type, age, favouriteCaretaker, previousOwner, timeInShelter, adopterID) VALUES (5, 'Luna', 'Dog', 1, 3, 1, 11, 5);
INSERT INTO Animal (petID, animalName, type, age, favouriteCaretaker, previousOwner, timeInShelter, adopterID) VALUES (6, 'Domino', 'Hamster', 1, 3, 1, 2, NULL);
INSERT INTO Animal (petID, animalName, type, age, favouriteCaretaker, previousOwner, timeInShelter, adopterID) VALUES (7, 'Patch', 'Dog', 2, 5, 4, 2, NULL);
INSERT INTO Animal (petID, animalName, type, age, favouriteCaretaker, previousOwner, timeInShelter, adopterID) VALUES (8, 'Pirate', 'Cat', 2, 4, 4, 11, NULL);
INSERT INTO Animal (petID, animalName, type, age, favouriteCaretaker, previousOwner, timeInShelter, adopterID) VALUES (9, 'Cloudy', 'Bunny', 3, 2, NULL, 7, NULL);
INSERT INTO Animal (petID, animalName, type, age, favouriteCaretaker, previousOwner, timeInShelter, adopterID) VALUES (10, 'Smoothie', 'Bunny', 3, 2, NULL, 7, NULL);

INSERT INTO VetAppointment (vetDate, vetTime, vetLicenseID, reason, petID) VALUES ('2023-10-20', '14:00:00', 1, 'Checkup', 1);
INSERT INTO VetAppointment (vetDate, vetTime, vetLicenseID, reason, petID) VALUES ('2023-10-21', '10:30:00', 2, 'Vaccination', 2);
INSERT INTO VetAppointment (vetDate, vetTime, vetLicenseID, reason, petID) VALUES ('2023-10-22', '15:15:00', 3, 'Dental cleaning', 3);
INSERT INTO VetAppointment (vetDate, vetTime, vetLicenseID, reason, petID) VALUES ('2023-10-23', '11:00:00', 4, 'Spaying', 4);
INSERT INTO VetAppointment (vetDate, vetTime, vetLicenseID, reason, petID) VALUES ('2023-10-24', '13:45:00', 5, 'Checkup', 5);

INSERT INTO Worker (workerID, hourlyPay) VALUES (1, 15);
INSERT INTO Worker (workerID, hourlyPay) VALUES (2, 17);
INSERT INTO Worker (workerID, hourlyPay) VALUES (3, 14); 
INSERT INTO Worker (workerID, hourlyPay) VALUES (4, 18); 
INSERT INTO Worker (workerID, hourlyPay) VALUES (5, 16);

INSERT INTO Volunteer (volunteerID, hoursVolunteered) VALUES (6, 20);
INSERT INTO Volunteer (volunteerID, hoursVolunteered) VALUES (7, 25); 
INSERT INTO Volunteer (volunteerID, hoursVolunteered) VALUES (8, 18);
INSERT INTO Volunteer (volunteerID, hoursVolunteered) VALUES (9, 30); 
INSERT INTO Volunteer (volunteerID, hoursVolunteered) VALUES (10, 22); 

INSERT INTO Post (postID, postType, description, postingDate, caretakerID) VALUES (1, 'Announcement', 'Adoption event this weekend!', '2023-10-25', 1);
INSERT INTO Post (postID, postType, description, postingDate, caretakerID) VALUES (2, 'News', 'New arrivals in the shelter', '2023-10-26', 2);
INSERT INTO Post (postID, postType, description, postingDate, caretakerID) VALUES (3, 'Update', 'Vet check-ups for all animals', '2023-10-27', 3); 
INSERT INTO Post (postID, postType, description, postingDate, caretakerID) VALUES (4, 'Event', 'Volunteer appreciation day', '2023-10-28', 3);
INSERT INTO Post (postID, postType, description, postingDate, caretakerID) VALUES (5, 'Adoption', 'Adopt a furry friend today', '2023-10-29', 1);

INSERT INTO AdoptionDetails (adoptionID, petID, adopterID, caretakerID, adoptionDate, notes) VALUES (1, 1, 1, 1, '2023-10-20', 'friendly cat’);
INSERT INTO AdoptionDetails (adoptionID, petID, adopterID, caretakerID, adoptionDate, notes) VALUES (2, 2, 2, 2, '2023-10-21', 'playful dog’);
INSERT INTO AdoptionDetails (adoptionID, petID, adopterID, caretakerID, adoptionDate, notes) VALUES (3, 3, 3, 3, '2023-10-22', 'loud cat’);
INSERT INTO AdoptionDetails (adoptionID, petID, adopterID, caretakerID, adoptionDate, notes) VALUES (4, 4, 4, 4, '2023-10-23', 'really soft bunny’); 
INSERT INTO AdoptionDetails (adoptionID, petID, adopterID, caretakerID, adoptionDate, notes) VALUES (5, 5, 5, 5, '2023-10-24', 'quiet dog');

INSERT INTO PetAdopter (petID, adopterID) VALUES (1, 1);
INSERT INTO PetAdopter (petID, adopterID) VALUES (2, 2); 
INSERT INTO PetAdopter (petID, adopterID) VALUES (3, 3); 
INSERT INTO PetAdopter (petID, adopterID) VALUES (4, 4); 
INSERT INTO PetAdopter (petID, adopterID) VALUES (5, 5);

INSERT INTO Appointment (petID, caretakerID, customerID, apptDate, apptTime) VALUES (6, 1, 1, '2023-01-15', '10:00:00');
INSERT INTO Appointment (petID, caretakerID, customerID, apptDate, apptTime) VALUES (7, 2, 2, '2023-02-20', '14:30:00');
INSERT INTO Appointment (petID, caretakerID, customerID, apptDate, apptTime) VALUES (8, 3, 3, '2023-03-10', '11:45:00');
INSERT INTO Appointment (petID, caretakerID, customerID, apptDate, apptTime) VALUES (9, 4, 4, '2023-04-05', '16:15:00');
INSERT INTO Appointment (petID, caretakerID, customerID, apptDate, apptTime) VALUES (10, 5, 5, '2023-05-12', '09:30:00');

INSERT INTO Donation (customerID, caretakerID, amount) VALUES (1, 1, 100);
INSERT INTO Donation (customerID, caretakerID, amount) VALUES (2, 2, 150);
INSERT INTO Donation (customerID, caretakerID, amount) VALUES (3, 3, 200); 
INSERT INTO Donation (customerID, caretakerID, amount) VALUES (4, 4, 50);
INSERT INTO Donation (customerID, caretakerID, amount) VALUES (5, 5, 75);

INSERT INTO Item (itemID, itemName, quantity) VALUES (1, 'Pet Food', 100);
INSERT INTO Item (itemID, itemName, quantity) VALUES (2, 'Blankets', 50);
INSERT INTO Item (itemID, itemName, quantity) VALUES (3, 'Toys', 75);
INSERT INTO Item (itemID, itemName, quantity) VALUES (4, 'Medicine', 25);
INSERT INTO Item (itemID, itemName, quantity) VALUES (5, 'Leashes', 30);

INSERT INTO ItemPurchase (customerID, caretakerID, itemID) VALUES (1, 1, 3);
INSERT INTO ItemPurchase (customerID, caretakerID, itemID) VALUES (2, 1, 5); 
INSERT INTO ItemPurchase (customerID, caretakerID, itemID) VALUES (3, 3, 1); 
INSERT INTO ItemPurchase (customerID, caretakerID, itemID) VALUES (4, 5, 4); 
INSERT INTO ItemPurchase (customerID, caretakerID, itemID) VALUES (5, 3, 5);

INSERT INTO Vet (vetLicenseID, vetName) VALUES (1, 'Dr. Allan’);
INSERT INTO Vet (vetLicenseID, vetName) VALUES (2, 'Dr. Papper’);
INSERT INTO Vet (vetLicenseID, vetName) VALUES (3, 'Dr. Lorde’);
INSERT INTO Vet (vetLicenseID, vetName) VALUES (4, 'Dr. Levette’); 
INSERT INTO Vet (vetLicenseID, vetName) VALUES (5, 'Dr. Michaels');

INSERT INTO AnimalCaretakerPC (caretakerPostalCode, caretakerCity) VALUES ('12345', 'Narnia’);
INSERT INTO AnimalCaretakerPC (caretakerPostalCode, caretakerCity) VALUES ('67890', 'Atlantis’);
INSERT INTO AnimalCaretakerPC (caretakerPostalCode, caretakerCity) VALUES ('34567', 'Brokeburn’);
INSERT INTO AnimalCaretakerPC (caretakerPostalCode, caretakerCity) VALUES ('87654', 'Lancaster’);
INSERT INTO AnimalCaretakerPC (caretakerPostalCode, caretakerCity) VALUES ('43210', 'Columbus');

INSERT INTO PostDateAndType (postingDate, postType) VALUES ('2023-10-25', 'Announcement’);
INSERT INTO PostDateAndType (postingDate, postType) VALUES ('2023-10-26', 'News’);
INSERT INTO PostDateAndType (postingDate, postType) VALUES ('2023-10-27', 'Update’); 
INSERT INTO PostDateAndType (postingDate, postType) VALUES ('2023-10-28', 'Event’);
INSERT INTO PostDateAndType (postingDate, postType) VALUES ('2023-10-29', 'Adoption');

INSERT INTO AdopterPCs (adopterPostalCode, adopterCity) VALUES ('12345', 'Narnia’);
INSERT INTO AdopterPCs (adopterPostalCode, adopterCity) VALUES ('23456', 'Atlantis’); 
INSERT INTO AdopterPCs (adopterPostalCode, adopterCity) VALUES ('34567', 'Brokeburn’); 
INSERT INTO AdopterPCs (adopterPostalCode, adopterCity) VALUES ('45678', 'Lancaster’);
INSERT INTO AdopterPCs (adopterPostalCode, adopterCity) VALUES ('56789', 'Columbus');

INSERT INTO ItemPrice (itemID, total) VALUES (5, 200);
INSERT INTO ItemPrice (itemID, total) VALUES (2, 100);
INSERT INTO ItemPrice (itemID, total) VALUES (1, 150);
INSERT INTO ItemPrice (itemID, total) VALUES (4, 75);
INSERT INTO ItemPrice (itemID, total) VALUES (3, 90);
