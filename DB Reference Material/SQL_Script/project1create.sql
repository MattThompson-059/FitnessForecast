create table Factory
(F_ID int,
F_StreetInfo char(100),
F_CityAndState char(50),
F_ZipCode int,
F_YearBuilt int,
primary key (F_ID));

create table Insurance
(I_ID int,
primary key (I_ID));

create table AssemblyLine
( ItemType char(100),
FloorNum int,
F_ID int,
primary key (FloorNum, F_ID),
foreign key (F_ID) references Factory(F_ID));

create table Employee
(E_ID int,
E_SSN int,
E_First char(40),
E_Last char(40),
F_ID int,
Mentor_ID int,
I_ID int,
I_EnrollmentDate int,
I_Cost double,
yearsworked int,
primary key (E_ID),
foreign key (Mentor_ID) references Employee(E_ID),
foreign key (F_ID) references Factory(F_ID),
foreign key (I_ID) references Insurance (I_ID),
unique (E_SSN));

insert into Factory values ('001', '200 F Street', 'New York, New York', '18452', '1995');
insert into Factory values ('002',  '123 Drury Lane', 'Sydney, Australia', '12345', '2000');
insert into Factory values ('003', '1 North Pole Place', 'North Pole, Antartica', '12353', '1');


insert into Insurance values ('001');
insert into Insurance values ('002');
insert into Insurance values ('003');
insert into Insurance values ('004');
insert into Insurance values ('005');


insert into AssemblyLine values ('automobile', '2', '001');
insert into AssemblyLine values ('books', '1', '003');
insert into AssemblyLine values ('candy', '3', '002');
insert into AssemblyLine values ('candy', '5', '003');

insert into Employee values ('002', '012345677', 'Mark', 'Mjolnir', '002', null, '004', '02131998', '700', '2');
insert into Employee values ('006', '012345673', 'Matt', 'Shiner', '002', '007', '005', '01192020', '1600', '0');
insert into Employee values ('007', '012345672', 'Alex', 'Grossman', '004', null, '002', '01142021', '1400', '1');
insert into Employee values ('008', '012345671', 'Freya', 'Atreus', '004' , '001', '004', '06132022', '1500', '3');
insert into Employee values ('009', '012345670', 'Joseph', 'Rasputin', '004' , '008', '005', '03121995', '1500', '5');


