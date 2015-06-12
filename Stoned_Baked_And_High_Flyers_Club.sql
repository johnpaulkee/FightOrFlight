DROP TABLE Customer;
DROP TABLE Country;
DROP TABLE Airline_Employee_Employed_With;
DROP TABLE BagTag_Luggage_StartingDestination_FinalDestination;
DROP TABLE Airport_LocatedIn;
DROP TABLE Domestic;
DROP TABLE International;
DROP TABLE Airline_Headquartered_In;
DROP TABLE Plane_Owned_By;
DROP TABLE Low_Capacity;
DROP TABLE High_Capacity;
DROP TABLE Regional_Flights;
DROP TABLE Long_Distance_Flights;
DROP TABLE Frequent_Flyer;
DROP TABLE Luggage_Represents;
DROP TABLE Belongs_To;
DROP TABLE Is_Issued;
DROP TABLE Ticket_Purchase;
DROP TABLE Discounted_Purchase;
DROP TABLE Add;
DROP TABLE Posts;
DROP TABLE Alliance;
DROP TABLE Is_In;
DROP TABLE Going;
DROP TABLE With;
DROP TABLE Boarding_Pass_For_Flight;
DROP TABLE Comprised_Of;

CREATE TABLE Customer(
cust_ID INTEGER,
blacklisted CHAR(1),
custName VARCHAR2(255) NOT NULL,
credit_card_number INTEGER,
PRIMARY KEY (cust_ID),
CONSTRAINT boolean
CHECK (blacklisted = 'Y' OR blacklisted = 'N')
);

CREATE TABLE Country(
name VARCHAR2(255),
language VARCHAR2(255),
PRIMARY KEY (name)
);

CREATE TABLE Airline_Employee_Employed_With(
employeeID INTEGER,
airline_code INTEGER NOT NULL,
discounts NUMBER,
employee_name VARCHAR2(255) NOT NULL,
PRIMARY KEY (employeeID),
FOREIGN KEY (airline_code) REFERENCES Airline_Headquartered_In,
CHECK (100 >= discounts >= 0)
);

CREATE TABLE BagTag_Luggage_StartingDestination_FinalDestination(
bt_id INTEGER,
weight INTEGER NOT NULL,
source_airport_code CHAR(3) NOT NULL,
destination_airport_code CHAR(3) NOT NULL,
PRIMARY KEY (bt_id),
FOREIGN KEY (source_airport_code) REFERENCES Airport_LocatedIn(airport_code),
FOREIGN KEY (destination_airport_code) REFERENCES Airport_LocatedIn(airport_code),
CHECK (weight > 0)
);

CREATE TABLE Airport_LocatedIn(
	airport_code CHAR(3),
	num_of_domestic_gates INTEGER,
	city VARCHAR2(255),
	country_name VARCHAR2(255) NOT NULL,
	PRIMARY KEY (airport_code),
	FOREIGN KEY (country_name) REFERENCES Country(name)
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

CREATE TABLE Airline_Headquartered_In(
airline_code INTEGER,
airline_name VARCHAR2(255) NOT NULL,
name VARCHAR2(255) NOT NULL,
PRIMARY KEY (airport_code),
FOREIGN KEY (name) REFERENCES Country(name)
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
FOREIGN KEY (plane_ID) REFERENCES Plane_Owned_By,
FOREIGN KEY (airline_code) REFERENCES Airline_Headquartered_In
);

CREATE TABLE Regional_Flights(
plane_ID INTEGER,
airline_code INTEGER,
airport_code CHAR(3),
PRIMARY KEY (plane_ID, airline_code, airport_code),
FOREIGN KEY (plane_ID) REFERENCES Low_Capacity,
FOREIGN KEY (airline_code) REFERENCES Airline_Headquartered_In,
FOREIGN KEY (airport_code) REFERENCES Domestic
);

CREATE TABLE Long_Distance_Flights(
plane_ID INTEGER,
airport_code INTEGER,
airport_code CHAR(3),
PRIMARY KEY (plane_ID, airline_code, airport_code),
FOREIGN KEY (plane_ID) REFERENCES High_Capacity,
FOREIGN KEY (airline_code) REFERENCES Airline_Headquartered_In,
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
FOREIGN KEY (bID) REFERENCES BagTag_Luggage_StartingDestination_FinalDestination,
CHECK (weight >= 0)
);

CREATE TABLE Belongs_To(
bID INTEGER,
cust_ID INTEGER,
PRIMARY KEY (bID, cust_ID),
FOREIGN KEY (bID) REFERENCES BagTag_Luggage_StartingDestination_FinalDestination,
FOREIGN KEY (cust_ID) REFERENCES Customer
);

CREATE TABLE Is_Issued(
bID INTEGER,
tID INTEGER,
PRIMARY KEY (bID,tID),
FOREIGN KEY (bID) REFERENCES BagTag_Luggage_StartingDestination_FinalDestination,
FOREIGN KEY (tID) REFERENCES Ticket_Purchase
);

CREATE TABLE Ticket_Purchase(
tID INTEGER,
cust_ID INTEGER NOT NULL,
payment_total NUMBER,
payment_type VARCHAR2(255),
seat CHAR(3),
class VARCHAR2(20),
price NUMBER NOT NULL,
PRIMARY KEY(tID),
FOREIGN KEY (cust_ID) REFERENCES Customer,
CONSTRAINT class
CHECK (class = 'Economy' OR class='Business' OR class='First')
);

CREATE TABLE Discounted_Purchase(
tID INTEGER,
employeeID INTEGER,
airline_code INTEGER,
PRIMARY KEY (tID),
FOREIGN KEY (employeeID) REFERENCES Airline_Employee_Employed_With,
FOREIGN KEY (airline_code) REFERENCES Airline_Headquartered_In
);

CREATE TABLE Add(
tID INTEGER,
airline_code INTEGER.
PRIMARY KEY (tID),
FOREIGN KEY (tID) REFERENCES Ticket_Purchase,
FOREIGN KEY (airline_code) REFERENCES Airline_Headquartered_In
);

CREATE TABLE Posts(
tID INTEGER,
alliance VARCHAR2(255)
PRIMARY KEY (tID),
FOREIGN KEY (tID) REFERENCES Ticket_Purchase,
FOREIGN KEY (alliance) REFERENCES Alliance(name)
);

CREATE TABLE Alliance(
name VARCHAR2(255),
PRIMARY KEY (name)
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

CREATE TABLE With(
boarding_ID INTEGER,
flight_num INTEGER,
from_airport_code CHAR(3),
to_airport_code CHAR(3),
tID INTEGER,
plane_ID INTEGER NOT NULL,
airline_code INTEGER,
PRIMARY KEY (boarding_ID, flight_num, from_airport_code, to_airport_code, tID, airline_code),
FOREIGN KEY (boarding_ID) REFERENCES Boarding_Pass_For_Flight,
FOREIGN KEY (flight_num) REFERENCES Boarding_Pass_For_Flight,
FOREIGN KEY (from_airport_code) REFERENCES Airport_LocatedIn(airport_code),
FOREIGN KEY (to_airport_code) REFERENCES Airport_LocatedIn(airport_code),
FOREIGN KEY (tID) REFERENCES Ticket_Purchase,
FOREIGN KEY (plane_ID) REFERENCES Plane_Owned_By,
FOREIGN KEY (airport_code) REFERENCES Airline_Headquartered_In
);

CREATE TABLE Boarding_Pass_For_Flight(
boarding_ID INTEGER,
flight_num INTEGER,
weight INTEGER,
seatNumber CHAR(3),
from_airport_code CHAR(3),
to_airport_code CHAR(3),
PRIMARY KEY (boarding_ID, flight_num, from_airport_code, to, airline_code),
FOREIGN KEY (from_airport_code) REFERENCES Airport_LocatedIn(airport_code),
FOREIGN KEY (to_airport_code) REFERENCES Airport_LocatedIn(airport_code),
FOREIGN KEY (airline_code) REFERENCES Airline_Headquartered_In
);

CREATE TABLE Comprised_Of(
boarding_ID INTEGER,
flight_num INTEGER,
from_airport_code CHAR(3),
to_airport_code CHAR(3),
airline_code INTEGER,
tID INTEGER,
PRIMARY KEY (boarding_ID, flight_num, from_airport_code, to_airport_code, airline_code),
FOREIGN KEY (boarding_ID) REFERENCES Boarding_Pass_For_Flight,
FOREIGN KEY (flight_num) REFERENCES Boarding_Pass_For_Flight,
FOREIGN KEY (from_airport_code) REFERENCES Airport_LocatedIn(airport_code),
FOREIGN KEY (to_airport_code) REFERENCES Airport_LocatedIn(airport_code),
FOREIGN KEY (tID) REFERENCES Ticket_Purchase,
FOREIGN KEY (boarding_ID) REFERENCES Boarding_Pass_For_Flight
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

INSERT INTO BagTag_Luggage_StartingDestination_FinalDestination
VALUES (0, 40, 'YVR', 'WAR');

INSERT INTO BagTag_Luggage_StartingDestination_FinalDestination
VALUES (1, 32, 'WAR', 'YVR');

INSERT INTO BagTag_Luggage_StartingDestination_FinalDestination
VALUES (2, 45, 'YVR', 'LAX');

INSERT INTO BagTag_Luggage_StartingDestination_FinalDestination
VALUES (3, 22, 'LAX', 'NYA');

INSERT INTO BagTag_Luggage_StartingDestination_FinalDestination
VALUES (4, 23, 'WAR', 'FRK');

INSERT INTO Airport_LocatedIn
VALUES ('TOR', 4, 'Toronto', 'Pearson International');

INSERT INTO Airport_LocatedIn
VALUES ('ADS', 2, 'Addis Ababa', 'Pearson International');