DROP TABLE Appointment;

DROP TABLE PetAdopter;

DROP TABLE AdoptionDetails;

DROP TABLE Post;

DROP TABLE Volunteer;

DROP TABLE Worker;

DROP TABLE VetAppointment;

DROP TABLE Animal;

DROP TABLE Adopter;

DROP TABLE Customer;

DROP TABLE AnimalCaretaker;

DROP TABLE FundraiserEvent;

CREATE TABLE FundraiserEvent (
    eventID INTEGER PRIMARY KEY, 
    eventType VARCHAR2(50), 
    eventDayTime DATE UNIQUE, 
    donationGoal NUMBER
    );

CREATE TABLE AnimalCaretaker (
    caretakerID INTEGER PRIMARY KEY, 
    caretakerName VARCHAR2(100), 
    fundEventID INTEGER, 
    caretakerAddress VARCHAR2(50), 
    caretakerPostalCode VARCHAR2(8), 
    FOREIGN KEY (fundEventID) REFERENCES FundraiserEvent(eventID)
    );

CREATE TABLE Customer (
    customerID INTEGER PRIMARY KEY, 
    customerName VARCHAR2(100)
    );

CREATE TABLE Adopter (
    adopterID INTEGER PRIMARY KEY, 
    numOfAdoptions INTEGER, 
    safeOwnerRating INTEGER, 
    adopterPostalCode VARCHAR2(8), 
    adopterAddress VARCHAR2(50), 
    FOREIGN KEY (customerID) REFERENCES Customer(customerID)
    );

CREATE TABLE Animal (
    petID INTEGER PRIMARY KEY, 
    animalName VARCHAR2(50), 
    type VARCHAR2(25), 
    age INTEGER, 
    favouriteCaretaker INTEGER, 
    previousOwner INTEGER, 
    timeInShelter INTEGER, 
    adopterID INTEGER, 
    FOREIGN KEY (favouriteCaretaker) REFERENCES AnimalCaretaker(caretakerID), 
    FOREIGN KEY (previousOwner) REFERENCES Customer(customerID), 
    FOREIGN KEY (adopterID) REFERENCES Adopter(adopterID)
    );

CREATE TABLE VetAppointment (vetDayTime DATE PRIMARY KEY, vetLicenseID INTEGER, reason VARCHAR2(250), petID INTEGER, FOREIGN KEY (petID) REFERENCES Animal(petID));

CREATE TABLE Worker (workerID INTEGER PRIMARY KEY, hourlyPay INTEGER, FOREIGN KEY (workerID) REFERENCES AnimalCaretaker(caretakerID) ON DELETE CASCADE);

CREATE TABLE Volunteer (volunteerID INTEGER PRIMARY KEY, hoursVolunteered INTEGERFOREIGN KEY (volunteerID) REFERENCES AnimalCaretaker(caretakerID) ON DELETE CASCADE;);

CREATE TABLE Post (postID INTEGER PRIMARY KEY, postType VARCHAR2(25), description VARCHAR2(100), postingDate DATE UNIQUE, caretakerID INTEGER,FOREIGN KEY (caretakerID) REFERENCES AnimalCaretaker(caretakerID));

CREATE TABLE AdoptionDetails (adoptionID INTEGER PRIMARY KEY, petID INTEGER UNIQUE, adopterID INTEGER, caretakerID INTEGER, adoptionDate DATE, notes VARCHAR2(200),FOREIGN KEY (petID) REFERENCES Animal(petID),FOREIGN KEY (adopterID) REFERENCES Adopter(adopterID),FOREIGN KEY (caretakerID) REFERENCES AnimalCaretaker(caretakerID),);

CREATE TABLE PetAdopter (petID INTEGER PRIMARY KEY, adopterID INTEGER,FOREIGN KEY (petID) REFERENCES Animal(petID),FOREIGN KEY (adopterID) REFERENCES Adopter(adopterID));

CREATE TABLE Appointment (petID INTEGER, caretakerID INTEGER, customerID INTEGER, apptDayTime DATE, FOREIGN KEY (petID) REFERENCES Animal(petID), FOREIGN KEY (caretakerID) REFERENCES AnimalCaretaker(caretakerID), FOREIGN KEY (customerID) REFERENCES Customer(customerID), PRIMARY KEY (petID, caretakerID, customerID));