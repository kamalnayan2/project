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
ALTER TABLE admine ALTER COLUMN password TYPE character varying(255);
ALTER TABLE admine ALTER COLUMN email TYPE character varying(100);


ALTER TABLE admine ALTER COLUMN admineid ADD GENERATED ALWAYS AS IDENTITY;

CREATE or replace TABLE events (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    event_date DATE NOT NULL,
    event_time VARCHAR(50) NOT NULL,
    location VARCHAR(255) NOT NULL,
    description TEXT NOT NULL
);

CREATE TABLE requests (
    id SERIAL PRIMARY KEY,
    description TEXT NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    image_path VARCHAR(255) -- Optional: to store the path of the uploaded image
);

CREATE TABLE payments (
    id SERIAL PRIMARY KEY,
    amount NUMERIC NOT NULL,
    currency VARCHAR(10) NOT NULL,
    payment_id VARCHAR(255) NOT NULL,
    status VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE balances (
    MemberID INT PRIMARY KEY,
    balance NUMERIC NOT NULL,
    FOREIGN KEY (MemberID) REFERENCES Member(MemberID) ON DELETE CASCADE
);
ALTER TABLE payments ADD COLUMN member_id INT REFERENCES balances(MemberID);

CREATE TABLE Events (
    id SERIAL PRIMARY KEY,
    event_name VARCHAR(255) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE maintenance_requests
ADD COLUMN member_id INTEGER;

-- Assuming you have a members table with member_id as the primary key
ALTER TABLE maintenance_requests
ADD CONSTRAINT fk_member
FOREIGN KEY (member_id) REFERENCES members(member_id);