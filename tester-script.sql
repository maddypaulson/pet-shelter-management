
DROP TABLE Volunteer;

DROP TABLE Worker;

DROP TABLE VetAppointment;

ALTER TABLE VetAppointment DROP CONSTRAINT va_fk;
DROP TABLE Animal;

ALTER TABLE Adopter DROP CONSTRAINT a_pk;
ALTER TABLE Animal DROP CONSTRAINT a_fk_po;
DROP TABLE Customer;

ALTER TABLE Animal DROP CONSTRAINT a_fk_aid;
DROP TABLE Adopter;

ALTER TABLE Animal DROP CONSTRAINT a_fk_fc;
ALTER TABLE Worker DROP CONSTRAINT w_pk;
ALTER TABLE Volunteer DROP CONSTRAINT v_pk;
DROP TABLE AnimalCaretaker;

ALTER TABLE AnimalCaretaker DROP CONSTRAINT ac_fk_fe;
DROP TABLE FundraiserEvent;


CREATE TABLE FundraiserEvent (eventID INTEGER CONSTRAINT fe_pk PRIMARY KEY, eventType VARCHAR2(50), eventDayTime DATE CONSTRAINT fe_u UNIQUE, donationGoal NUMBER);

CREATE TABLE AnimalCaretaker (caretakerID INTEGER CONSTRAINT ac_pk PRIMARY KEY, caretakerName VARCHAR2(100), fundEventID INTEGER CONSTRAINT ac_fk_fe REFERENCES FundraiserEvent(eventID), caretakerAddress VARCHAR2(50), caretakerPostalCode VARCHAR2(8));

CREATE TABLE Customer (customerID INTEGER CONSTRAINT c_pk PRIMARY KEY, customerName VARCHAR2(100));

CREATE TABLE Adopter (adopterID INTEGER CONSTRAINT a_pk PRIMARY KEY REFERENCES Customer(customerID) ON DELETE CASCADE, numOfAdoptions INTEGER, safeOwnerRating INTEGER, adopterPostalCode VARCHAR2(8), adopterAddress VARCHAR2(50));

CREATE TABLE Animal (petID INTEGER CONSTRAINT animal_pk PRIMARY KEY, animalName VARCHAR2(50), type VARCHAR2(25), age INTEGER, favouriteCaretaker INTEGER CONSTRAINT a_fk_fc REFERENCES AnimalCaretaker(caretakerID), previousOwner INTEGER CONSTRAINT a_fk_po REFERENCES Customer(customerID), timeInShelter INTEGER, adopterID INTEGER CONSTRAINT a_fk_aid REFERENCES Adopter(adopterID));

CREATE TABLE VetAppointment (vetDayTime DATE  CONSTRAINT va_pk PRIMARY KEY, vetLicenseID INTEGER, reason VARCHAR2(250), petID INTEGER CONSTRAINT va_fk REFERENCES Animal(petID));

CREATE TABLE Worker (workerID INTEGER CONSTRAINT w_pk PRIMARY KEY REFERENCES AnimalCaretaker(caretakerID) ON DELETE CASCADE, hourlyPay INTEGER);

CREATE TABLE Volunteer (volunteerID INTEGER CONSTRAINT v_pk PRIMARY KEY REFERENCES AnimalCaretaker(caretakerID) ON DELETE CASCADE, hoursVolunteered INTEGER);


