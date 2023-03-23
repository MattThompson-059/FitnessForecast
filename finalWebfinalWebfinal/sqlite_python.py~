import sqlite3
from sqlite3 import Error
import csv


'''
==============================================================================================
HOW TO SET UP A DATABASE ON YOUR OWN COMPUTER
==============================================================================================

Go to your folder where you have your final project
side that folder, create a folder name database

the branch should look like this

final_folder
	- index.php
	- styles.css
	- views.php
	- models.php
	- database (php)
	

go into the database folder and copy the database.db file there

final_folder
	- database (folder)
		- database.db
		
in terminal go to final folder

chmod o+w database
cd database
chmod o+w database.db

ls -l 

your database.db should have rw-r--rw 


after that, run this file in your final_folder using

python sqlite_python.py 


this will create two table (colors and users) for you to use


your can use python sqlite_python.py to set your tables back to default version as well. 
==============================================================================================

'''

# remove all database if it exists and create new database using csv files
def initiate_database_table(database):
	sql_drop_colors = "drop table colors;"
	sql_drop_users = "drop table users;"
	sql_create_color_table = """CREATE TABLE IF NOT EXISTS colors (hex varchar(255) PRIMARY KEY NOT NULL, name varchar(255) NOT NULL, basic_color varchar(255) NOT NULL, free varchar(255) NOT NULL, red varchar(255) NOT NULL, green varchar(255) NOT NULL, blue varchar(255) NOT NULL);"""
	sql_create_user_table = "create table if not exists users(id int primary key not null, email varchar(255) not null, password varchar(255) not null, privilege varchar(255) not null);"
	# create a database connection
	conn = create_connection(database)
	# create tables
	if conn is not None:
		# create projects table
		run_sql(conn, sql_drop_colors)
		run_sql(conn, sql_drop_users)
		run_sql(conn, sql_create_color_table)
		run_sql(conn, sql_create_user_table)
		print("Tables created.")
	
	else:
		print("Error! cannot create the database connection.")
	
	input_all_user_to_table("users.csv")
	input_all_color_to_table("color_name.csv")

# run the sql command that is passed in
def run_sql(conn, sql):
    try:
        c = conn.cursor()
        c.execute(sql)
    except Error as e:
        print(e)
        
# create a database connection to the given database file
def create_connection(db_file):
    conn = None
    try:
        conn = sqlite3.connect(db_file)
        return conn
    except Error as e:
        print(e)

    return conn

# input all of the colors to the color table inside of the file_name database
def input_all_color_to_table(file_name):
	conn = sqlite3.connect('database/database.db')
	
	inputed_color = set()
	read_file = open(file_name, "r")
	line = read_file.readline()
	count = 1
	while line != "":
		parts = line.split(",")
		hex_value = parts[2]
		color_name = parts[1]
		red = int(parts[3])
		green = int(parts[4])
		blue = int(parts[5])
		
		# basic color
		basic_color_name = get_basic_color(red, green, blue)
			
		free = "False"
		if count % 8 == 0:
			free = "True"
		
		if hex_value not in inputed_color:
			row_id = insert_color(conn, hex_value, color_name, basic_color_name, free, red, green, blue)
			print("Current row of csv: ", count)
			print("Inserted at Row ID of table: ", row_id)
			print("Basic color: ", basic_color_name)
			inputed_color.add(hex_value)
		
		line = read_file.readline()
		count += 1

# insert a color to the color table
def insert_color(conn, hex_value, color_name, basic_color_name, free, red, green, blue):
	print(color_name)
	params = (hex_value, color_name, basic_color_name, free, red, green, blue)
	cur = conn.cursor()
	cur.execute("INSERT INTO colors VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')" % params)
	conn.commit()
	print("color inserted")
	return cur.lastrowid
	
# get basic color using RGB value
def get_basic_color(red, green, blue):
	
	minimumValue = 0
	maximumValue = 0
	if red <= green and green <= blue:
		minimumValue = red
		maximumValue = blue
	elif green <= red and red <= blue:
		minimumValue = green
		maximumValue = blue
	elif red <= blue and blue <= green:
		minimumValue = red
		maximumValue = green
	elif blue <= red and red <= green:
		minimumValue = blue
		maximumValue = green
	elif green <= blue and blue <= red:
		minimumValue = green
		maximumValue = red
	elif blue <= green and green <= red:
		minimumValue = blue
		maximumValue = red
		
	
	if abs(minimumValue - maximumValue) < 40:
		color = "Black"
	elif abs(red - green) < 45 and minimumValue == blue:
		color = "Yellow"
	elif red == maximumValue and abs(red - green) < 100 and minimumValue == blue:
		color = "Orange"
	elif abs(red - blue) < 30 and minimumValue == green:
		color = "Purple"
	elif maximumValue == red:
		color = "Red"
	elif maximumValue == green:
		color = "Green"
	elif maximumValue == blue:
		color = "Blue"
	
	return color
	
# add users to users table	
def input_user(conn, user_id, email, password, privilege):
	params = (user_id, email, password, privilege)
	cur = conn.cursor()
	cur.execute("INSERT INTO users VALUES (%d, '%s', '%s', '%s')" % params)
	conn.commit()
	print("user inserted. Email: ", email)
	return cur.lastrowid
	
# input all the users to the user table inside the filename database		
def input_all_user_to_table(filename):
	conn = sqlite3.connect('database/database.db')
	read_file = open(filename, "r")
	line = read_file.readline()
	user_id = 1
	while line != "":
		parts = line.split(",")
		email = parts[0]
		password = parts[1]
		privilege = parts[2]
		row_id = input_user(conn, user_id, email, password, privilege)
		print("inserted at row id: ", row_id)
		
		user_id += 1
		line = read_file.readline()
	

database = "database/database.db"
initiate_database_table(database)