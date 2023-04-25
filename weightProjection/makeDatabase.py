import pandas as pd
import sqlite3

# Read the CSV file into a DataFrame
df = pd.read_csv('../sql_connection/finalizedDataset.csv')

# Connect to the database
conn = sqlite3.connect('ExercisePortfolio.db')
c = conn.cursor()

c.execute('CREATE TABLE IF NOT EXISTS exercises (Salt VARCHAR(20), Exercise VARCHAR(40), Day INTEGER, '
          'Experience VARCHAR(20), RepTime FLOAT,SetTime FLOAT,Reps INTEGER,Sets INTEGER,MaxWeightSet INTEGER, '
          'CurrentPR INTEGER,CurrPRDate DATE,GoalPR INTEGER, ProjPR FLOAT)')
conn.commit()

df.to_sql('exercises', conn, if_exists='replace', index=False)

c.execute('''
SELECT * FROM exercises
WHERE Projectible is 'Yes'
''')

for row in c.fetchall():
    print(row)





# Loop through each table in the DataFrame
# for table in df['table_name'].unique():
#     # Subset the DataFrame for the current table
#     table_df = df[df['table_name'] == table]
#
#     # Create the table in the database
#     create_query = f"CREATE TABLE IF NOT EXISTS {table} ({', '.join(table_df['column_name'])})"
#     conn.execute(create_query)
#
#     # Insert the data into the table
#     insert_query = f"INSERT INTO {table} ({', '.join(table_df['column_name'])}) VALUES ({', '.join(['?' for _ in range(len(table_df))])})"
#     data = [tuple(row) for row in table_df.to_numpy()]
#     conn.executemany(insert_query, data)

# Commit the changes and close the connection
# conn.commit()
# conn.close()


# user_table = "create table User (Salt varchar(20), primary key (Salt), Password VARCHAR(15), height float, weight float, experience varchar(10), age int (2));"
# routine_table = "create table Routine(Salt varchar(20), days int(5), sets int, reps int, foreign key (Salt) references User(Salt));"
# goal_table = "create table Goal (Salt varchar(20), OneRepMax int(3), ReachDate date, foreign key (Salt) references User(Salt));"
# exercises_table = "create table Exercises (Salt varchar(20), CurrentMax int not null auto_increment, biceps varchar, triceps varchar, abs varchar, chest varchar, back varchar, legs varchar, primary key(CurrentMax), foreign key (Salt) references User(Salt));"


# CREATE TABLE ExerciseLog (
#     Exercise VARCHAR(40),
#     Day INTEGER,
#     Experience VARCHAR(20),
#     RepTime FLOAT,
#     SetTime FLOAT,
#     Reps INTEGER,
#     Sets INTEGER,
#     MaxWeightSet INTEGER,
#     CurrentPR INTEGER,
#     CurrPRDate DATE,
#     GoalPR INTEGER,
#     ProjPR FLOAT,
# );