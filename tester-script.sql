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

CREATE TABLE FundraiserEvent (eventID INTEGER CONSTRAINT fe_pk PRIMARY KEY, eventType VARCHAR2(50), eventDayTime DATE CONSTRAINT fe_u UNIQUE, donationGoal NUMBER);

CREATE TABLE AnimalCaretaker (caretakerID INTEGER CONSTRAINT ac_pk PRIMARY KEY, caretakerName VARCHAR2(100), fundEventID INTEGER CONSTRAINT ac_fk_fe REFERENCES FundraiserEvent(eventID), caretakerAddress VARCHAR2(50), caretakerPostalCode VARCHAR2(8));

CREATE TABLE Customer (customerID INTEGER CONSTRAINT c_pk PRIMARY KEY, customerName VARCHAR2(100));

CREATE TABLE Adopter (adopterID INTEGER CONSTRAINT a_pk PRIMARY KEY REFERENCES Customer(customerID) ON DELETE CASCADE, numOfAdoptions INTEGER, safeOwnerRating INTEGER, adopterPostalCode VARCHAR2(8), adopterAddress VARCHAR2(50));

CREATE TABLE Animal (petID INTEGER CONSTRAINT animal_pk PRIMARY KEY, animalName VARCHAR2(50), type VARCHAR2(25), age INTEGER, favouriteCaretaker INTEGER CONSTRAINT a_fk_fc REFERENCES AnimalCaretaker(caretakerID), previousOwner INTEGER CONSTRAINT a_fk_po REFERENCES Customer(customerID), timeInShelter INTEGER, adopterID INTEGER CONSTRAINT a_fk_aid REFERENCES Adopter(adopterID));

CREATE TABLE VetAppointment (vetDayTime DATE CONSTRAINT va_pk PRIMARY KEY, vetLicenseID INTEGER, reason VARCHAR2(250), petID INTEGER CONSTRAINT va_fk REFERENCES Animal(petID));

CREATE TABLE Worker (workerID INTEGER CONSTRAINT w_pk PRIMARY KEY REFERENCES AnimalCaretaker(caretakerID) ON DELETE CASCADE, hourlyPay INTEGER);

CREATE TABLE Volunteer (volunteerID INTEGER CONSTRAINT v_pk PRIMARY KEY REFERENCES AnimalCaretaker(caretakerID) ON DELETE CASCADE, hoursVolunteered INTEGER);

CREATE TABLE Post (postID INTEGER CONSTRAINT p_pk PRIMARY KEY, postType VARCHAR2(25), description VARCHAR2(100), postingDate DATE CONSTRAINT p_u UNIQUE, caretakerID INTEGER CONSTRAINT p_fk_ac REFERENCES AnimalCaretaker(caretakerID));

CREATE TABLE AdoptionDetails (adoptionID INTEGER CONSTRAINT ad_pk PRIMARY KEY, petID INTEGER CONSTRAINT ad_fk_u UNIQUE REFERENCES Animal(petID), adopterID INTEGER CONSTRAINT ad_fk_aid REFERENCES Adopter(adopterID), caretakerID INTEGER CONSTRAINT ad_fk_ac REFERENCES AnimalCaretaker(caretakerID), adoptionDate DATE, notes VARCHAR2(200));

CREATE TABLE PetAdopter (petID INTEGER CONSTRAINT pa_pk PRIMARY KEY REFERENCES Animal(petID), adopterID INTEGER CONSTRAINT pa_fk_aid REFERENCES Adopter(adopterID));

CREATE TABLE Appointment (petID INTEGER CONSTRAINT appt_fk_p REFERENCES Animal(petID), caretakerID INTEGER CONSTRAINT appt_fk_ac REFERENCES AnimalCaretaker(caretakerID), customerID INTEGER CONSTRAINT appt_fk_c REFERENCES Customer(customerID), apptDayTime DATE, CONSTRAINT appt_pk PRIMARY KEY (petID, caretakerID, customerID));