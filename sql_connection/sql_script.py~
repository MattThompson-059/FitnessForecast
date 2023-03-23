user_table = "create table User (Username varchar(20), primary key (Username), Password VARCHAR(15), height float, weight float, experience varchar(10), age int (2));"
routine_table = "create table Routine(Username varchar(20), days int(5), sets int, reps int, foreign key (Username) references User(Username));"
goal_table = "create table Goal (Username varchar(20), OneRepMax int(3), ReachDate date, foreign key (Username) references User(Username));"
exercises_table = "create table Exercises (Username varchar(20), CurrentMax int not null auto_increment, biceps varchar, triceps varchar, abs varchar, chest varchar, back varchar, legs varchar, primary key(CurrentMax), foreign key (Username) references User(Username));" 

# min weight 4.7 lbs, max weight 1400 lbs.
# min height 2'1" in, max height 8'11" in.