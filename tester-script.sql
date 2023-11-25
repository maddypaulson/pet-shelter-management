-- drop table statements
DROP TABLE ItemPrice;
DROP TABLE AdopterPC;
DROP TABLE PostDateAndType;
DROP TABLE AnimalCaretakerPC;
DROP TABLE Vet;
DROP TABLE ItemPurchase;
DROP TABLE Item;
DROP TABLE Donation;
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

-- create table statements
CREATE TABLE FundraiserEvent (eventID INTEGER GENERATED ALWAYS AS IDENTITY CONSTRAINT fe_pk PRIMARY KEY, eventType VARCHAR2(50), eventDayTime DATE CONSTRAINT fe_u UNIQUE, donationGoal NUMBER);

CREATE TABLE AnimalCaretaker (caretakerID INTEGER GENERATED ALWAYS AS IDENTITY CONSTRAINT ac_pk PRIMARY KEY, caretakerName VARCHAR2(100), fundEventID INTEGER CONSTRAINT ac_fk_fe REFERENCES FundraiserEvent(eventID), caretakerAddress VARCHAR2(50), caretakerPostalCode VARCHAR2(8));

CREATE TABLE Customer (customerID INTEGER GENERATED ALWAYS AS IDENTITY CONSTRAINT c_pk PRIMARY KEY, customerName VARCHAR2(100));

CREATE TABLE Adopter (adopterID INTEGER CONSTRAINT a_pk PRIMARY KEY REFERENCES Customer(customerID) ON DELETE CASCADE, numOfAdoptions INTEGER, safeOwnerRating INTEGER, adopterPostalCode VARCHAR2(8), adopterAddress VARCHAR2(50));

CREATE TABLE Animal (petID INTEGER GENERATED ALWAYS AS IDENTITY CONSTRAINT animal_pk PRIMARY KEY, animalName VARCHAR2(50), type VARCHAR2(25), age INTEGER, favouriteCaretaker INTEGER CONSTRAINT a_fk_fc REFERENCES AnimalCaretaker(caretakerID), previousOwner INTEGER CONSTRAINT a_fk_po REFERENCES Customer(customerID), timeInShelter INTEGER, adopterID INTEGER CONSTRAINT a_fk_aid REFERENCES Adopter(adopterID));

CREATE TABLE VetAppointment (vetDayTime DATE CONSTRAINT va_pk PRIMARY KEY, vetLicenseID INTEGER, reason VARCHAR2(250), petID INTEGER CONSTRAINT va_fk REFERENCES Animal(petID));

CREATE TABLE Worker (workerID INTEGER CONSTRAINT w_pk PRIMARY KEY REFERENCES AnimalCaretaker(caretakerID) ON DELETE CASCADE, hourlyPay INTEGER);

CREATE TABLE Volunteer (volunteerID INTEGER CONSTRAINT v_pk PRIMARY KEY REFERENCES AnimalCaretaker(caretakerID) ON DELETE CASCADE, hoursVolunteered INTEGER);

CREATE TABLE Post (postID INTEGER GENERATED ALWAYS AS IDENTITY CONSTRAINT p_pk PRIMARY KEY, postType VARCHAR2(25), description VARCHAR2(100), postingDate DATE CONSTRAINT p_u UNIQUE, caretakerID INTEGER CONSTRAINT p_fk_ac REFERENCES AnimalCaretaker(caretakerID));

CREATE TABLE AdoptionDetails (adoptionID INTEGER GENERATED ALWAYS AS IDENTITY CONSTRAINT ad_pk PRIMARY KEY, petID INTEGER CONSTRAINT ad_fk_u UNIQUE REFERENCES Animal(petID), adopterID INTEGER CONSTRAINT ad_fk_aid REFERENCES Adopter(adopterID), caretakerID INTEGER CONSTRAINT ad_fk_ac REFERENCES AnimalCaretaker(caretakerID), adoptionDate DATE, notes VARCHAR2(200));

CREATE TABLE PetAdopter (petID INTEGER CONSTRAINT pa_pk PRIMARY KEY REFERENCES Animal(petID), adopterID INTEGER CONSTRAINT pa_fk_aid REFERENCES Adopter(adopterID));

CREATE TABLE Appointment (petID INTEGER CONSTRAINT appt_fk_p REFERENCES Animal(petID), caretakerID INTEGER CONSTRAINT appt_fk_ac REFERENCES AnimalCaretaker(caretakerID), customerID INTEGER CONSTRAINT appt_fk_c REFERENCES Customer(customerID), apptDayTime DATE, CONSTRAINT appt_pk PRIMARY KEY (petID, caretakerID, customerID));

CREATE TABLE Donation (customerID INTEGER CONSTRAINT d_fk_c REFERENCES Customer(customerID), caretakerID INTEGER CONSTRAINT d_fk_ac REFERENCES AnimalCaretaker(caretakerID), amount INTEGER, CONSTRAINT d_pk PRIMARY KEY (customerID, caretakerID));

CREATE TABLE Item (itemID INTEGER GENERATED ALWAYS AS IDENTITY CONSTRAINT i_pk PRIMARY KEY, itemName VARCHAR2(25), quantity INTEGER);

CREATE TABLE ItemPurchase (customerID INTEGER CONSTRAINT ip_fk_c REFERENCES Customer(customerID), caretakerID INTEGER CONSTRAINT ip_fk_ac REFERENCES AnimalCaretaker(caretakerID), itemID INTEGER CONSTRAINT ip_fk_i REFERENcES Item(itemID), CONSTRAINT ip_pk PRIMARY KEY (customerID, caretakerID, itemID));

CREATE TABLE Vet (vetLicenseID INTEGER GENERATED ALWAYS AS IDENTITY CONSTRAINT vet_pk PRIMARY KEY, vetName VARCHAR2(50));

CREATE TABLE AnimalCaretakerPC (caretakerPostalCode VARCHAR2(8) CONSTRAINT acpc_pk PRIMARY KEY, caretakerCity VARCHAR2(25));

CREATE TABLE PostDateAndType (postingDate DATE CONSTRAINT pdat_pk PRIMARY KEY, postType VARCHAR2(50));

CREATE TABLE AdopterPC (adopterPostalCode VARCHAR2(8) CONSTRAINT apc_pk PRIMARY KEY, adopterCity VARCHAR2(25));

CREATE TABLE ItemPrice (itemID INTEGER CONSTRAINT itp_pk PRIMARY KEY REFERENCES Item(itemID), total INTEGER);

-- insert statements
INSERT INTO FundraiserEvent (eventType, eventDayTime, donationGoal) VALUES ('Charity Auction', to_date('2023/11/01 18:00', 'YYYY/MM/DD HH:MI'), 5000);
INSERT INTO FundraiserEvent (eventType, eventDayTime, donationGoal) VALUES ('Pet Walkathon', to_date('2023/11/15 10:00', 'YYYY/MM/DD HH:MI'), 3000);
INSERT INTO FundraiserEvent (eventType, eventDayTime, donationGoal) VALUES ('Adoption Fair', to_date('2023/11/30 14:30', 'YYYY/MM/DD HH:MI'), 2000);
INSERT INTO FundraiserEvent (eventType, eventDayTime, donationGoal) VALUES ('Pet Costume Contest', to_date('2023/12/10 15:00', 'YYYY/MM/DD HH:MI'), 2500);
INSERT INTO FundraiserEvent (eventType, eventDayTime, donationGoal) VALUES ('Animal Rescue Gala', to_date('2023/12/25 19:00', 'YYYY/MM/DD HH:MI'), 7000);
