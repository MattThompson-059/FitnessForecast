# README
This README details the capstone project for the Randolph Macon College; Fitness Forecast: A Routine Generator for Weight Training Goals.

# MODEL - Weight and Data Projection

	The folder contains a Python program that performs data analysis on an example dataset of a user who would use this application/service.

	# ExerciseAnalysis.py
		
		This Python file is a set of functions to conduct analysis and demonstrate application features using incoming user data.

			- getDataFrame: Creates the pandas dataframe for analysis

			- setRoundingRule: Sets the rounding rule to the nearest base amount (for single rep maximum calculation).

			- _roundingRule: PRIVATE METHOD to return the rounded value to the nearest base amount (for single rep maximum calculation).

			- get1RM: Dependent on the retrieved data, then projects the training single rep maximum.

			- getMuscleSize: Determines the size of each muscle group and associates it with its corresponding muscle group.

			- getWeeklyGain: Based on the size of the muscle group assigns the amount of growth expected for a week for the body part of the exercise done.

			- evalGoal: Calculates the amount of time (in days) it will take to reach the user's goal of a chosen single rep maximum.

			- getProgresGraph: Creates a graph illustrating the weekly gain and accumulative amount of time to reach that goal
		
	# finalizedDataset.csv

		A dataset of 96 exercises - a large starting point to build further exercise functionality. To demonstrate application features, a subset of exercises was chosen to highlight development opportunities and capabilities using ExerciseAnalysis.py.
	
	# capstone_PROD

		*** 
		NOTE: You must currently hardcode the exact location of where finalizedDataset.csv is located for the complete functionality of the program.
		***
		
		An example of prototype functionality is showcased in the JupyterLab notebook. Executes salient aspects of ExerciseAnalysis.py and highlights CRUD operations using the finalizedDataset.csv.
		

# VIEW -
 
 
# CONTROL - 




# DEVELOPMENT PARTNERS
This project was developed by Matt Thompson, Ethan Olmsted, and Zak Espigh.