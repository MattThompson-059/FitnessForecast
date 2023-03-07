create table SeatRow
(seatrow char(2),
primary key (seatrow)
);
create table SeatNum
(num int,
primary key (num)
);
/*somehow add not null values when you do alter table
*/
/**modified seat table
*/
CREATE TABLE seat 
(SeatRow TEXT(3), 
SeatNumber INT(3), 
Section VARCHAR(10), 
Side VARCHAR(6), 
PricingTier VARCHAR(13), 
Wheelchair boolean),

create table Customer
(CustomerID int,
FirstName char(45),
LastName char(45),
PaymentMethod varchar (2),
Primary Key (CustomerID)
);
create table Ticket
(TicketNumber int not null AUTO_INCREMENT,
CustomerID int,
SeatRow int not null,
SeatNumber int not null,
ShowTime date,
Primary key (TicketNumber),
Foreign key (CustomerID) references Customer(CustomerID)
);
create table reminders
(
id int auto_increment,
showtime int,
message varchar(255) not null,
primary key (id)
);
Delimiter $$
create trigger error_Message_check_if_after_1990
before update
on Ticket
for each row
begin
if new.showTime < 1990 then
insert into reminders(showtime, message)
values(new.showtime, 'Please update showtime so it is after 1990.
'
);
end if;
end$$
Delimiter ;
create table customer_archives(
Id
int
NOT NULL auto_increment,
CustomerID int,
FirstName char(45),
LastName char(45),
primary key(Id)
);
delimiter $$
create trigger customer_delete_add_to_archives
before delete
on customer
for each row
begin
insert into customer_archives(CustomerID, FirstName, LastName)
values (old.CustomerID, old.FirstName, old.LastName);
end $$
DELIMITER ;
delimiter $$
create trigger autoUppercase_nameFirst
before insert
on Customer
for each row
set new.FirstName = upper(new.firstName);
end $$
Delimiter $$
