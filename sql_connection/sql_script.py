user_table = "create table User (UserID int, Username varchar(20), primary key (Username), Password VARCHAR(15), height float, weight float, experience varchar(10), age int (2);"

goal_table = "create table Goal (OneRepMax int(3), ReachDate date, foreign key (UserID) references User(UserID);"

