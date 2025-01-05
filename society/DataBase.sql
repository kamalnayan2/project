create table Member(
MemberID int primary key,
name varchar(50),
flatno Varchar(10),
mobileno varchar(10),
password varchar(30)
);

CREATE TABLE Maintenance(
    MID INT PRIMARY KEY,
    MemberID INT,
    Description TEXT,
    Status VARCHAR(20),
    price bigint,
    FOREIGN KEY (MemberID) REFERENCES Member(MemberID)
);

select * from Maintenance

CREATE TABLE Facility (
    FacilityID INT PRIMARY KEY,
    Name VARCHAR(50),
    Description TEXT,
    Availability BOOLEAN
);

CREATE TABLE Bookings (
    BookingID INT PRIMARY KEY,
    FacilityID INT,
    MemberID INT,
    BookingDate DATE,
    FOREIGN KEY (FacilityID) REFERENCES Facility(FacilityID),
    FOREIGN KEY (MemberID) REFERENCES Member(MemberID)
);

create table Complain(
ComplainID int primary key,
MemberID int,
ComplainDescription text,
Date date,
status varchar(30),
FOREIGN KEY (MemberID) REFERENCES Member(MemberID)
);

create table Admine(
AdmineID int primary key,
UserName varchar(20),
PassWord varchar(30),
Address varchar(30),
MobileNo varchar(10)
);


CREATE TABLE FinancialRecords (
    RecordID INT PRIMARY KEY,
    Description TEXT,
    Amount DECIMAL(10, 2),
    Type VARCHAR(10),
    Date DATE
);

CREATE TABLE Events (
    EventID INT PRIMARY KEY,
    Name VARCHAR(50),
    Date DATE,
    Description TEXT
);

