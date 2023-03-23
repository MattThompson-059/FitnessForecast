user_table = "create table User (UserID int, Username varchar(20), primary key (Username), Password VARCHAR(15), height float, weight float, experience varchar(10), age int (2));"
routine_table = "create table Routine(UserID int, days int(5), sets int, reps int, foreign key (UserID) references User(UserID));"
goal_table = "create table Goal (UserID int, OneRepMax int(3), ReachDate date, foreign key (UserID) references User(UserID));"
exercises_table = "create table Exercises (UserID int, CurrentMax int not null auto_increment, biceps varchar, triceps varchar, abs varchar, chest varchar, back varchar, legs varchar, primary key(CurrentMax), foreign key (UserID) references User(UserID));" 

# min weight 4.7 lbs, max weight 1400 lbs.
# min height 2'1" in, max height 8'11" in.