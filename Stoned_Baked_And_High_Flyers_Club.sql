DROP TABLE TICKET_PURCHASE CASCADE CONSTRAINT;
DROP TABLE AUTHORS CASCADE CONSTRAINT;
DROP TABLE PUBLISHERS CASCADE CONSTRAINT;
DROP TABLE TITLES CASCADE CONSTRAINT;
DROP TABLE TITLEAUTHORS CASCADE CONSTRAINT;
DROP TABLE EDITORS CASCADE CONSTRAINT;
DROP TABLE TITLEDITORS CASCADE CONSTRAINT;
DROP TABLE SALES CASCADE CONSTRAINT;
DROP TABLE SALESDETAILS CASCADE CONSTRAINT;
DROP TABLE TAB1 CASCADE CONSTRAINT;
DROP TABLE CUSTOMER CASCADE CONSTRAINT;
DROP TABLE CUSTOMER_LOGIN CASCADE CONSTRAINT;
DROP TABLE COUNTRY CASCADE CONSTRAINT;
DROP TABLE AIRLINE_HEADQUARTERED_IN  CASCADE CONSTRAINT;
DROP TABLE AIRLINE_EMPLOYEE_EMPLOYED_WITH CASCADE CONSTRAINT;
DROP TABLE AIRLINE_EMPLOYEE_LOGIN CASCADE CONSTRAINT;
DROP TABLE AIRPORT_LOCATEDIN CASCADE CONSTRAINT;
DROP TABLE BAGTAG_LUGGAGE_STARTD_FINALD CASCADE CONSTRAINT;
DROP TABLE DOMESTIC CASCADE CONSTRAINT;
DROP TABLE INTERNATIONAL CASCADE CONSTRAINT;
DROP TABLE AIRLINE_LOGIN CASCADE CONSTRAINT;
DROP TABLE PLANE_OWNED_BY CASCADE CONSTRAINT;
DROP TABLE LOW_CAPACITY CASCADE CONSTRAINT;
DROP TABLE HIGH_CAPACITY CASCADE CONSTRAINT;
DROP TABLE REGIONAL_FLIGHTS CASCADE CONSTRAINT;
DROP TABLE LONG_DISTANCE_FLIGHTS CASCADE CONSTRAINT;
DROP TABLE FREQUENT_FLYER CASCADE CONSTRAINT;
DROP TABLE LUGGAGE_REPRESENTS CASCADE CONSTRAINT;
DROP TABLE BELONGS_TO CASCADE CONSTRAINT;
DROP TABLE DISCOUNTED_PURCHASE CASCADE CONSTRAINT;
DROP TABLE ALLIANCE CASCADE CONSTRAINT;
DROP TABLE IS_IN CASCADE CONSTRAINT;
DROP TABLE GOING CASCADE CONSTRAINT;
DROP TABLE BOARDING_PASS_FOR_FLIGHT CASCADE CONSTRAINT;
DROP TABLE BRANCH CASCADE CONSTRAINT;

CREATE TABLE Customer(
cust_ID INTEGER,
blacklisted CHAR(1),
custName VARCHAR2(255) NOT NULL,
credit_card_number INTEGER,
PRIMARY KEY (cust_ID),
CONSTRAINT boolean
CHECK (blacklisted = 'Y' OR blacklisted = 'N')
);

CREATE TABLE Customer_Login(
username VARCHAR2(30),
cust_ID INTEGER,
password VARCHAR2(30),
PRIMARY KEY (username),
FOREIGN KEY (cust_ID) REFERENCES Customer,
UNIQUE (cust_ID)
);

CREATE TABLE Country(
name VARCHAR2(255),
language VARCHAR2(255),
PRIMARY KEY (name)
);

CREATE TABLE Airline_Headquartered_In(
airline_code INTEGER,
airline_name VARCHAR2(255) NOT NULL,
name VARCHAR2(255) NOT NULL,
PRIMARY KEY (airline_code),
FOREIGN KEY (name) REFERENCES Country(name)
);

CREATE TABLE Airline_Employee_Employed_With(
employeeID INTEGER,
airline_code INTEGER NOT NULL,
discounts NUMBER,
employee_name VARCHAR2(255) NOT NULL,
PRIMARY KEY (employeeID, airline_code),
FOREIGN KEY (airline_code) REFERENCES Airline_Headquartered_In,
CHECK (100 >= discounts AND discounts >= 0)
);

CREATE TABLE Airline_Employee_Login(
username VARCHAR2(30),
employeeID INTEGER,
password VARCHAR2(30),
airline_code INTEGER,
PRIMARY KEY (username),
FOREIGN KEY (employeeID, airline_code) REFERENCES Airline_Employee_Employed_With,
UNIQUE (employeeID, airline_code)
);

CREATE TABLE Airport_LocatedIn(
	airport_code CHAR(3),
	num_of_domestic_gates INTEGER,
	city VARCHAR2(255),
	country_name VARCHAR2(255) NOT NULL,
	airport_name VARCHAR2(255),
	PRIMARY KEY (airport_code),
	FOREIGN KEY (country_name) REFERENCES Country(name)
);

CREATE TABLE BagTag_Luggage_StartD_FinalD(
bt_id INTEGER,
weight INTEGER NOT NULL,
source_airport_code CHAR(3) NOT NULL,
destination_airport_code CHAR(3) NOT NULL,
PRIMARY KEY (bt_id),
FOREIGN KEY (source_airport_code) REFERENCES Airport_LocatedIn(airport_code),
FOREIGN KEY (destination_airport_code) REFERENCES Airport_LocatedIn(airport_code),
CHECK (weight > 0)
);

CREATE TABLE Domestic(
airport_code CHAR(3),
PRIMARY KEY (airport_code),
FOREIGN KEY (airport_code) REFERENCES Airport_LocatedIn
);

CREATE TABLE International(
airport_code CHAR(3),
num_internatiol_gates INTEGER,
PRIMARY KEY (airport_code),
FOREIGN KEY (airport_code) REFERENCES Airport_LocatedIn
);

CREATE TABLE Airline_Login(
username VARCHAR2(30),
airline_code INTEGER,
password VARCHAR2(30),
PRIMARY KEY (username),
FOREIGN KEY (airline_code) REFERENCES Airline_Headquartered_In,
UNIQUE (airline_code)
);

CREATE TABLE Plane_Owned_By(
airline_code INTEGER,
plane_ID INTEGER,
capacity INTEGER NOT NULL,
company VARCHAR2(255),
PRIMARY KEY (airline_code, plane_ID),
FOREIGN KEY(airline_code) REFERENCES Airline_Headquartered_In,
CHECK (capacity >= 1)
);

CREATE TABLE Low_Capacity(
plane_ID INTEGER,
airline_code INTEGER,
PRIMARY KEY (plane_ID, airline_code),
FOREIGN KEY (plane_ID, airline_code) REFERENCES Plane_Owned_By(plane_ID, airline_code)
);

CREATE TABLE High_Capacity(
plane_ID INTEGER,
airline_code INTEGER,
PRIMARY KEY (plane_ID, airline_code),
FOREIGN KEY (plane_ID, airline_code) REFERENCES Plane_Owned_By(plane_ID, airline_code)
);

CREATE TABLE Regional_Flights(
plane_ID INTEGER,
airline_code INTEGER,
airport_code CHAR(3),
PRIMARY KEY (plane_ID, airline_code, airport_code),
FOREIGN KEY (plane_ID, airline_code) REFERENCES Low_Capacity,
FOREIGN KEY (airport_code) REFERENCES Domestic
);

CREATE TABLE Long_Distance_Flights(
plane_ID INTEGER,
airline_code INTEGER,
airport_code CHAR(3),
PRIMARY KEY (plane_ID, airline_code, airport_code),
FOREIGN KEY (plane_ID, airline_code) REFERENCES High_Capacity(plane_ID, airline_code),
FOREIGN KEY (airport_code) REFERENCES International
);

CREATE TABLE Frequent_Flyer(
cust_ID INTEGER,
airline_code INTEGER,
points INTEGER,
PRIMARY KEY (cust_ID, airline_code),
FOREIGN KEY (cust_ID) REFERENCES Customer,
FOREIGN KEY (airline_code) REFERENCES Airline_Headquartered_In
);

CREATE TABLE Luggage_Represents(
bID INTEGER,
weight INTEGER NOT NULL,
PRIMARY KEY (bID),
FOREIGN KEY (bID) REFERENCES BagTag_Luggage_StartD_FinalD,
CHECK (weight >= 0)
);

CREATE TABLE Belongs_To(
bID INTEGER,
cust_ID INTEGER,
PRIMARY KEY (bID, cust_ID),
FOREIGN KEY (bID) REFERENCES BagTag_Luggage_StartD_FinalD,
FOREIGN KEY (cust_ID) REFERENCES Customer
);

CREATE TABLE Ticket(
tID INTEGER,
seat CHAR(3),
class VARCHAR2(20),
price NUMBER NOT NULL,
PRIMARY KEY(tID),
CONSTRAINT class
CHECK (class = 'Economy' OR class='Business' OR class='First')
);

CREATE TABLE Is_Issued(
bID INTEGER,
tID INTEGER,
PRIMARY KEY (bID,tID),
FOREIGN KEY (bID) REFERENCES BagTag_Luggage_StartD_FinalD,
FOREIGN KEY (tID) REFERENCES Ticket
);

CREATE TABLE Customer_Purchase(
tID INTEGER,
cust_ID INTEGER,
payment_total NUMBER,
payment_type VARCHAR2(255),
PRIMARY KEY (tID),
FOREIGN KEY (tID) REFERENCES Ticket,
FOREIGN KEY (cust_ID) REFERENCES Customer
);

CREATE TABLE Discounted_Purchase(
tID INTEGER,
employeeID INTEGER,
airline_code INTEGER,
payment_total NUMBER,
payment_type VARCHAR2(255),
PRIMARY KEY (tID),
FOREIGN KEY (employeeID, airline_code) REFERENCES Airline_Employee_Employed_With
-- TODO: Correct discount constraint
);

CREATE TABLE Add_Ticket(
tID INTEGER,
airline_code INTEGER,
PRIMARY KEY (tID),
FOREIGN KEY (tID) REFERENCES Ticket,
FOREIGN KEY (airline_code) REFERENCES Airline_Headquartered_In
);

CREATE TABLE Alliance(
name VARCHAR2(255),
PRIMARY KEY (name)
);

CREATE TABLE Posts(
tID INTEGER,
alliance VARCHAR2(255),
PRIMARY KEY (tID),
FOREIGN KEY (tID) REFERENCES Ticket,
FOREIGN KEY (alliance) REFERENCES Alliance(name)
);

CREATE TABLE Is_In(
alliance VARCHAR2(255),
airline_code INTEGER,
PRIMARY KEY (alliance, airline_code),
FOREIGN KEY (alliance) REFERENCES Alliance(name),
FOREIGN KEY (airline_code) REFERENCES Airline_Headquartered_In
);

CREATE TABLE Going(
from_airport_code CHAR(3),
to_airport_code CHAR(3),
PRIMARY KEY (from_airport_code, to_airport_code),
FOREIGN KEY (from_airport_code) REFERENCES Airport_LocatedIn(airport_code),
FOREIGN KEY (to_airport_code) REFERENCES Airport_LocatedIn(airport_code)
);

CREATE TABLE Boarding_Pass_For_Flight(
boarding_ID INTEGER,
flight_num INTEGER,
weight INTEGER,
seatNumber CHAR(3),
from_airport_code CHAR(3),
to_airport_code CHAR(3),
airline_code INTEGER,
PRIMARY KEY (boarding_ID, flight_num, from_airport_code, to_airport_code, airline_code),
FOREIGN KEY (from_airport_code) REFERENCES Airport_LocatedIn(airport_code),
FOREIGN KEY (to_airport_code) REFERENCES Airport_LocatedIn(airport_code),
FOREIGN KEY (airline_code) REFERENCES Airline_Headquartered_In
);

CREATE TABLE Is_With(
boarding_ID INTEGER,
flight_num INTEGER,
from_airport_code CHAR(3),
to_airport_code CHAR(3),
tID INTEGER,
plane_ID INTEGER NOT NULL,
boardingID_airline_code INTEGER,
plane_airline_code INTEGER,
PRIMARY KEY (boarding_ID, flight_num, from_airport_code, to_airport_code, tID, boardingID_airline_code),
FOREIGN KEY (boarding_ID, flight_num, from_airport_code, to_airport_code, boardingID_airline_code) REFERENCES Boarding_Pass_For_Flight,
FOREIGN KEY (tID) REFERENCES Ticket,
FOREIGN KEY (plane_ID, plane_airline_code) REFERENCES Plane_Owned_By(plane_ID, airline_code)
);

CREATE TABLE Comprised_Of(
boarding_ID INTEGER,
flight_num INTEGER,
from_airport_code CHAR(3),
to_airport_code CHAR(3),
airline_code INTEGER,
tID INTEGER,
PRIMARY KEY (boarding_ID, flight_num, from_airport_code, to_airport_code, airline_code),
FOREIGN KEY (boarding_ID, flight_num, from_airport_code, to_airport_code, airline_code) REFERENCES Boarding_Pass_For_Flight,
FOREIGN KEY (tID) REFERENCES Ticket
);


INSERT INTO Customer
VALUES (0, 'N', 'William Donald', 123456789);

INSERT INTO Customer
VALUES (1, 'Y', 'Sharique Iglesias', 123123123);

INSERT INTO Customer
VALUES (2, 'N', 'Ghengis Khanister', NULL);

INSERT INTO Customer
VALUES (3, 'N', 'Ted Moseby', 111222333);

INSERT INTO Customer
VALUES (4, 'N', 'Paula Abdul', NULL);

INSERT INTO Country
VALUES ('Canada', 'English');

INSERT INTO Country
VALUES ('USA', 'English');

INSERT INTO Country
VALUES ('Pakistan', 'Urdu');

INSERT INTO Country
VALUES ('India', 'Hindi');

INSERT INTO Country
VALUES ('Poland', 'Polish');

INSERT INTO Country
VALUES ('France', 'French');

INSERT INTO Country
VALUES ('England', 'English');

INSERT INTO Country
VALUES ('Germany', 'German');

INSERT INTO Airline_Headquartered_In
VALUES (0, 'Lufthansa', 'Germany');

INSERT INTO Airline_Headquartered_In
VALUES (1, 'West Jet', 'USA');

INSERT INTO Airline_Headquartered_In
VALUES (2, 'Air Canada', 'Canada');

INSERT INTO Airline_Headquartered_In
VALUES (3, 'Air France', 'France');

INSERT INTO Airline_Headquartered_In
VALUES (4, 'Lot', 'Poland');

INSERT INTO Airline_Employee_Employed_With
VALUES (0, 4, 10.0, 'Jesus Diaz');

INSERT INTO Airline_Employee_Employed_With
VALUES (1, 3, 12.0, 'Marco Polo');

INSERT INTO Airline_Employee_Employed_With
VALUES (2, 1, 20.0, 'Fat Albert');

INSERT INTO Airline_Employee_Employed_With
VALUES (3, 0, 10.0, 'Ron Jeremy');

INSERT INTO Airline_Employee_Employed_With
VALUES (4, 2, 10.0, 'Debbie Dallas');

INSERT INTO Airport_LocatedIn
VALUES ('TOR', 4, 'Toronto', 'Canada', 'Pearson International Airport');

INSERT INTO Airport_LocatedIn
VALUES ('ADS', 2, 'Addis Ababa', 'India', 'Polyamorous Airport');

INSERT INTO Airport_LocatedIn
VALUES ('YVR', 8, 'Vancouver', 'Canada', 'Vancouver International Airport');

INSERT INTO Airport_LocatedIn
VALUES ('SEO', 7, 'Seoul', 'Pakistan', 'Kimchi Airport');

INSERT INTO Airport_LocatedIn
VALUES ('KRH', 3, 'Karachi', 'Pakistan', 'Kabab International Airport');

INSERT INTO Airport_LocatedIn
VALUES ('LON', 2, 'London', 'England', 'London Airport');

INSERT INTO Airport_LocatedIn
VALUES ('LAX', 6, 'Los Angeles', 'USA', 'Los Angeles International Airport');

INSERT INTO Airport_LocatedIn
VALUES ('WAR', 5, 'Warsaw', 'Poland', 'Warsaw International Airport');

INSERT INTO Airport_LocatedIn
VALUES ('FRK', 12, 'Frankfurt', 'Germany', 'Frankfurt Airport');

INSERT INTO Airport_LocatedIn
VALUES ('NYA', 9, 'New York', 'USA', 'Big Apple Airport');

INSERT INTO BagTag_Luggage_StartD_FinalD
VALUES (0, 40, 'YVR', 'WAR');

INSERT INTO BagTag_Luggage_StartD_FinalD
VALUES (1, 32, 'WAR', 'YVR');

INSERT INTO BagTag_Luggage_StartD_FinalD
VALUES (2, 45, 'YVR', 'LAX');

INSERT INTO BagTag_Luggage_StartD_FinalD
VALUES (3, 22, 'LAX', 'NYA');

INSERT INTO BagTag_Luggage_StartD_FinalD
VALUES (4, 23, 'WAR', 'FRK');

INSERT INTO Domestic
VALUES ('SEO');

INSERT INTO Domestic
VALUES ('NYA');

INSERT INTO Domestic
VALUES ('FRK');

INSERT INTO Domestic
VALUES ('ADS');

INSERT INTO Domestic
VALUES ('LON');

INSERT INTO International
VALUES ('YVR', 5);

INSERT INTO International
VALUES ('KRH', 3);

INSERT INTO International
VALUES ('TOR', 11);

INSERT INTO International
VALUES ('LAX', 5);

INSERT INTO International
VALUES ('WAR', 5);

INSERT INTO Plane_Owned_By
VALUES (0, 0, 80, 'Bombardier');

INSERT INTO Plane_Owned_By
VALUES (1, 0, 20, 'Boeing');

INSERT INTO Plane_Owned_By
VALUES (2, 1, 100, 'Airbus');

INSERT INTO Plane_Owned_By
VALUES (3, 2, 45, 'Lockheed');

INSERT INTO Plane_Owned_By
VALUES (4, 3, 80, 'Bombardier');

INSERT INTO Plane_Owned_By
VALUES (3, 0, 25, 'Boeing');

INSERT INTO Plane_Owned_By
VALUES (3, 1, 35, 'Bombardier');

INSERT INTO Plane_Owned_By
VALUES (3, 4, 35, 'Boeing');

INSERT INTO Plane_Owned_By
VALUES (4, 0, 30, 'Airbus');

INSERT INTO Plane_Owned_By
VALUES (4, 1, 90, 'Bombardier');

INSERT INTO Low_Capacity
VALUES (0, 4);

INSERT INTO Low_Capacity
VALUES (4, 3);

INSERT INTO Low_Capacity
VALUES (1, 3);

INSERT INTO Low_Capacity
VALUES (0, 3);

INSERT INTO Low_Capacity
VALUES (0, 1);

INSERT INTO High_Capacity
VALUES (0, 0);

INSERT INTO High_Capacity
VALUES (1, 2);

INSERT INTO High_Capacity
VALUES (2, 3);

INSERT INTO High_Capacity
VALUES (3, 4);

INSERT INTO High_Capacity
VALUES (1, 4);

INSERT INTO Regional_Flights
VALUES (0, 4, 'SEO');

INSERT INTO Regional_Flights
VALUES (0, 4, 'NYA');

INSERT INTO Regional_Flights
VALUES (0, 4, 'FRK');

INSERT INTO Regional_Flights
VALUES (0, 4, 'ADS');

INSERT INTO Regional_Flights
VALUES (0, 4, 'LON');

INSERT INTO Regional_Flights
VALUES (4, 3, 'SEO');

INSERT INTO Regional_Flights
VALUES (4, 3, 'NYA');

INSERT INTO Regional_Flights
VALUES (4, 3, 'FRK');

INSERT INTO Regional_Flights
VALUES (4, 3, 'ADS');

INSERT INTO Regional_Flights
VALUES (4, 3, 'LON');

INSERT INTO Regional_Flights
VALUES (1, 3, 'SEO');

INSERT INTO Regional_Flights
VALUES (1, 3, 'NYA');

INSERT INTO Regional_Flights
VALUES (1, 3, 'FRK');

INSERT INTO Regional_Flights
VALUES (1, 3, 'ADS');

INSERT INTO Regional_Flights
VALUES (1, 3, 'LON');

INSERT INTO Regional_Flights
VALUES (0, 3, 'SEO');

INSERT INTO Regional_Flights
VALUES (0, 3, 'NYA');

INSERT INTO Regional_Flights
VALUES (0, 3, 'FRK');

INSERT INTO Regional_Flights
VALUES (0, 3, 'ADS');

INSERT INTO Regional_Flights
VALUES (0, 3, 'LON');

INSERT INTO Regional_Flights
VALUES (0, 1, 'SEO');

INSERT INTO Regional_Flights
VALUES (0, 1, 'NYA');

INSERT INTO Regional_Flights
VALUES (0, 1, 'FRK');

INSERT INTO Regional_Flights
VALUES (0, 1, 'ADS');

INSERT INTO Regional_Flights
VALUES (0, 1, 'LON');

INSERT INTO Long_Distance_Flights
VALUES (0, 0, 'YVR');

INSERT INTO Long_Distance_Flights
VALUES (0, 0, 'KRH');

INSERT INTO Long_Distance_Flights
VALUES (0, 0, 'TOR');

INSERT INTO Long_Distance_Flights
VALUES (0, 0, 'LAX');

INSERT INTO Long_Distance_Flights
VALUES (0, 0, 'WAR');

INSERT INTO Long_Distance_Flights
VALUES (1, 2, 'YVR');

INSERT INTO Long_Distance_Flights
VALUES (1, 2, 'KRH');

INSERT INTO Long_Distance_Flights
VALUES (1, 2, 'TOR');

INSERT INTO Long_Distance_Flights
VALUES (1, 2, 'LAX');

INSERT INTO Long_Distance_Flights
VALUES (1, 2, 'WAR');

INSERT INTO Long_Distance_Flights
VALUES (2, 3, 'YVR');

INSERT INTO Long_Distance_Flights
VALUES (2, 3, 'KRH');

INSERT INTO Long_Distance_Flights
VALUES (2, 3, 'TOR');

INSERT INTO Long_Distance_Flights
VALUES (2, 3, 'LAX');

INSERT INTO Long_Distance_Flights
VALUES (2, 3, 'WAR');

INSERT INTO Long_Distance_Flights
VALUES (3, 4, 'YVR');

INSERT INTO Long_Distance_Flights
VALUES (3, 4, 'KRH');

INSERT INTO Long_Distance_Flights
VALUES (3, 4, 'TOR');

INSERT INTO Long_Distance_Flights
VALUES (3, 4, 'LAX');

INSERT INTO Long_Distance_Flights
VALUES (3, 4, 'WAR');

INSERT INTO Long_Distance_Flights
VALUES (1, 4, 'YVR');

INSERT INTO Long_Distance_Flights
VALUES (1, 4, 'KRH');

INSERT INTO Long_Distance_Flights
VALUES (1, 4, 'TOR');

INSERT INTO Long_Distance_Flights
VALUES (1, 4, 'LAX');

INSERT INTO Long_Distance_Flights
VALUES (1, 4, 'WAR');

INSERT INTO Frequent_Flyer
VALUES (0, 0, 100);

INSERT INTO Frequent_Flyer
VALUES (0, 1, 80);

INSERT INTO Frequent_Flyer
VALUES (0, 2, 2100);

INSERT INTO Frequent_Flyer
VALUES (1, 0, 300);

INSERT INTO Frequent_Flyer
VALUES (4, 0, 1500);

INSERT INTO Luggage_Represents
VALUES (0, 10);

INSERT INTO Luggage_Represents
VALUES (1, 22);

INSERT INTO Luggage_Represents
VALUES (2, 23);

INSERT INTO Luggage_Represents
VALUES (3, 18);

INSERT INTO Luggage_Represents
VALUES (4, 19);

INSERT INTO Belongs_To
VALUES (0, 0);

INSERT INTO Belongs_To
VALUES (0, 1);

INSERT INTO Belongs_To
VALUES (1, 2);

INSERT INTO Belongs_To
VALUES (2, 3);

INSERT INTO Belongs_To
VALUES (3, 4);

INSERT INTO Ticket
VALUES (0, '1A1', 'Economy', 300.0);

INSERT INTO Ticket
VALUES (1, '1X1', 'Economy', 1100.0);

INSERT INTO Ticket
VALUES (2, '6B3', 'First', 8000.0);

INSERT INTO Ticket
VALUES (3, '8F2', 'Business', 3000.0);

INSERT INTO Ticket
VALUES (4, '1D7', 'First', 4700.0);

INSERT INTO Ticket
VALUES (5, '5G5', 'Business', 2100.0);

INSERT INTO Ticket
VALUES (6, '1I1', 'Economy', 800.0);

INSERT INTO Ticket
VALUES (7, '0O0', 'Economy', 1000.0);

INSERT INTO Ticket
VALUES (8, '3E3', 'Economy', 670.0);

INSERT INTO Ticket
VALUES (9, '4J8', 'Economy', 550.0);

INSERT INTO Is_Issued
VALUES (0, 0);

INSERT INTO Is_Issued
VALUES (1, 0);

INSERT INTO Is_Issued
VALUES (2, 1);

INSERT INTO Is_Issued
VALUES (3, 2);

INSERT INTO Is_Issued
VALUES (4, 3);

INSERT INTO Customer_Purchase
VALUES (0, 0, 300.0, 'Credit Card');

INSERT INTO Customer_Purchase
VALUES (1, 1, 1100.0, 'Debit Card');

INSERT INTO Customer_Purchase
VALUES (2, 2, 8000.0, 'Cash');

INSERT INTO Customer_Purchase
VALUES (3, 3, 3000.0, 'Debit Card');

INSERT INTO Customer_Purchase
VALUES (4, 4, 4700.0, 'Credit Card');

INSERT INTO Discounted_Purchase
VALUES (5, 0, 4, 1890.0, 'Debit Card');

INSERT INTO Discounted_Purchase
VALUES (6, 1, 3, 704.0, 'Cash');

INSERT INTO Discounted_Purchase
VALUES (7, 2, 1, 800.0, 'Cash');

INSERT INTO Discounted_Purchase
VALUES (8, 3, 0, 603, 'Debit Card');

INSERT INTO Discounted_Purchase
VALUES (9, 4, 2, 495.0, 'Credit Card');

INSERT INTO Add_Ticket
VALUES (0, 0);

INSERT INTO Add_Ticket
VALUES (1, 1);

INSERT INTO Add_Ticket
VALUES (2, 2);

INSERT INTO Add_Ticket
VALUES (3, 3);

INSERT INTO Add_Ticket
VALUES (4, 4);

INSERT INTO Add_Ticket
VALUES (5, 0);

INSERT INTO Add_Ticket
VALUES (6, 1);

INSERT INTO Add_Ticket
VALUES (7, 2);

INSERT INTO Add_Ticket
VALUES (8, 3);

INSERT INTO Add_Ticket
VALUES (9, 4);

INSERT INTO Alliance
VALUES ('Star Alliance');

INSERT INTO Alliance
VALUES ('Pretty Alliance');

INSERT INTO Alliance
VALUES ('Superficial Alliance');

INSERT INTO Alliance
VALUES ('Underworld Alliance');

INSERT INTO Alliance
VALUES ('Migration Alliance');

INSERT INTO Posts
VALUES (5, 'Star Alliance');

INSERT INTO Posts
VALUES (6, 'Superficial Alliance');

INSERT INTO Posts
VALUES (7, 'Pretty Alliance');

INSERT INTO Posts
VALUES (8, 'Pretty Alliance');

INSERT INTO Posts
VALUES (9, 'Star Alliance');

INSERT INTO Is_In
VALUES ('Star Alliance', 0);

INSERT INTO Is_In
VALUES ('Star Alliance', 3);

INSERT INTO Is_In
VALUES ('Star Alliance', 4);

INSERT INTO Is_In
VALUES ('Migration Alliance', 2);

INSERT INTO Is_In
VALUES ('Pretty Alliance', 1);

INSERT INTO Going
VALUES ('LAX', 'YVR');

INSERT INTO Going
VALUES ('WAR', 'LAX');

INSERT INTO Going
VALUES ('WAR', 'TOR');

INSERT INTO Going
VALUES ('TOR', 'YVR');

INSERT INTO Going
VALUES ('LAX', 'TOR');

INSERT INTO Going
VALUES ('LON', 'TOR');

INSERT INTO Going
VALUES ('WAR', 'LON');

INSERT INTO Going
VALUES ('LON', 'LAX');

INSERT INTO Going
VALUES ('KRH', 'YVR');

INSERT INTO Going
VALUES ('TOR', 'KRH');

INSERT INTO Boarding_Pass_For_Flight
VALUES (0, 0, 23, '1A1', 'LAX', 'YVR', 0);

INSERT INTO Boarding_Pass_For_Flight
VALUES (1, 1, 18, '1X1', 'WAR', 'LAX', 1);

INSERT INTO Boarding_Pass_For_Flight
VALUES (2, 2, 22, '6B3', 'WAR', 'TOR', 2);

INSERT INTO Boarding_Pass_For_Flight
VALUES (3, 3, 18, '8F2', 'TOR', 'YVR', 3);

INSERT INTO Boarding_Pass_For_Flight
VALUES (4, 4, 22, '1D7', 'LAX', 'TOR', 4);

INSERT INTO Boarding_Pass_For_Flight
VALUES (5, 5, 26, '5G5', 'LON', 'TOR', 0);

INSERT INTO Boarding_Pass_For_Flight
VALUES (6, 6, 16, '1I1', 'WAR', 'LON', 1);

INSERT INTO Boarding_Pass_For_Flight
VALUES (7, 7, 21, '0O0', 'LON', 'LAX', 2);

INSERT INTO Boarding_Pass_For_Flight
VALUES (8, 8, 32, '3E3', 'KRH', 'YVR', 3);

INSERT INTO Boarding_Pass_For_Flight
VALUES (9, 9, 28, '4J8', 'TOR', 'KRH', 4);

INSERT INTO Is_With
VALUES (0, 0, 'LAX', 'YVR', 0, 0, 0, 0);

INSERT INTO Is_With
VALUES (1, 1, 'WAR', 'LAX', 1, 0, 1, 1);

INSERT INTO Is_With
VALUES (2, 2, 'WAR', 'TOR', 2, 1, 2, 2);

INSERT INTO Is_With
VALUES (3, 3, 'TOR', 'YVR', 3, 2, 3, 3);

INSERT INTO Is_With
VALUES (4, 4, 'LAX', 'TOR', 4, 3, 4, 4);

INSERT INTO Is_With
VALUES (5, 5, 'LON', 'TOR', 5, 0, 0, 3);

INSERT INTO Is_With
VALUES (6, 6, 'WAR', 'LON', 6, 1, 1, 3);

INSERT INTO Is_With
VALUES (7, 7, 'LON', 'LAX', 7, 4, 2, 3);

INSERT INTO Is_With
VALUES (8, 8, 'KRH', 'YVR', 8, 0, 3, 4);

INSERT INTO Is_With
VALUES (9, 9, 'TOR', 'KRH', 9, 1, 4, 4);

INSERT INTO Comprised_Of
VALUES (0, 0, 'LAX', 'YVR', 0, 0);

INSERT INTO Comprised_Of
VALUES (1, 1, 'WAR', 'LAX', 1, 1);

INSERT INTO Comprised_Of
VALUES (2, 2, 'WAR', 'TOR', 2, 2);

INSERT INTO Comprised_Of
VALUES (3, 3, 'TOR', 'YVR', 3, 3);

INSERT INTO Comprised_Of
VALUES (4, 4, 'LAX', 'TOR', 4, 4);

INSERT INTO Comprised_Of
VALUES (5, 5, 'LON', 'TOR', 0, 5);

INSERT INTO Comprised_Of
VALUES (6, 6, 'WAR', 'LON', 1, 6);

INSERT INTO Comprised_Of
VALUES (7, 7, 'LON', 'LAX', 2, 7);

INSERT INTO Comprised_Of
VALUES (8, 8, 'KRH', 'YVR', 3, 8);

INSERT INTO Comprised_Of
VALUES (9, 9, 'TOR', 'KRH', 4, 9);

INSERT INTO Customer_Login
VALUES ('Abracadabrar Musa', 0, 'iworkout...guys...iworkout');

INSERT INTO Customer_Login
VALUES ('Sharique Azibaziz', 1, 'iamindian');

INSERT INTO Customer_Login
VALUES ('jaypeepeepisspiss', 4, 'peepeepoopoo');

INSERT INTO Customer_Login
VALUES ('Kamilionaire Khanister', 2, '10/10swagpoints');

INSERT INTO Customer_Login
VALUES ('demo', 3, '123');

INSERT INTO Airline_Employee_Login
VALUES ('Flight Attendant', 0, 'iloveplanes', 4);

INSERT INTO Airline_Employee_Login
VALUES ('Pilot', 1, 'vroomvroom', 3);

INSERT INTO Airline_Employee_Login
VALUES ('Copilot', 2, 'snoresnore', 1);

INSERT INTO Airline_Employee_Login
VALUES ('Stewardess', 3, 'warmtowel?', 0);

INSERT INTO Airline_Employee_Login
VALUES ('demo', 4, '123', 2);

INSERT INTO Airline_Login
VALUES ('AirF', 3, 'jemapel');

INSERT INTO Airline_Login
VALUES ('lot', 4, 'polska');

INSERT INTO Airline_Login
VALUES ('Luft', 0, 'yadasauto');

INSERT INTO Airline_Login
VALUES ('mooseandbeavers', 2, 'ocanada');

INSERT INTO Airline_Login
VALUES ('demo', 1, '123');

-- CREATE TRIGGER categorizeSmallPlane
-- AFTER INSERT ON Plane_Owned_By
-- FOR EACH STATEMENT
-- INSERT INTO
-- Low_Capacity(plane_ID, airline_code)
-- SELECT plane_ID, airline_code
-- FROM Plane_Owned_By p
-- WHERE p.capacity <= 40;

