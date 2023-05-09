import os
import pandas as pd
import numpy as np 
import datetime as dt
from matplotlib import pyplot as plt

# set a rounding constant for calculations
ROUNDING_CONSTANT = 5.0


def getDataFrame(fileLocation, indexChoice="Exercise"):
    """
    Create a pandas dataframe for analysis 

    Parameters
    --------------------------------------------------------------------------------
        fileLocation : str
            The location of the file with data to analyze
            NOTE: only .csv and .xlsx scoped into development
        indexChoice : str, default "Exercise"
            The column to set as the pandas dataframe index

    Return
    --------------------------------------------------------------------------------
        A pandas dataframe of the exercise data
    
    """
    # Get the file extension
    file_extension = os.path.splitext(fileLocation)[1]
    if file_extension == '.csv':
        df = pd.read_csv(fileLocation)
    elif file_extension == '.xlsx':
        df = pd.read_excel(fileLocation)
    else:
        raise RuntimeError('This function only reads .csv or .xlsx formats - please' +
                           'save as one of these and try again.')
    if indexChoice != None:
        df.set_index(indexChoice, inplace=True)
    return df


def setRoundingRule(inputConstant):
    """
    Set the rounding rule to the nearest base amount

    Parameters
    --------------------------------------------------------------------------------
        inputConstant : float
            Allow the user to set the value that governs rounding
            
    Return
    --------------------------------------------------------------------------------
        The magic number ROUNDING_CONSTANT
    """
    ROUNDING_CONSTANT = inputConstant


def _roundingRule(inputValue, roundingIncrement=ROUNDING_CONSTANT):
    """
    PRIVATE METHOD
    Round to the nearest base amount

    Parameters
    --------------------------------------------------------------------------------
        inputValue : float
            The value to be roundeded
        roundingIncrement : float, default ROUNDING_CONSTANT
            The rounding value to govern rounding (2.5, 5, etc.)
            
    Return
    --------------------------------------------------------------------------------
        The input value rounded to the closest value base
    """
    roundedValue = roundingIncrement * round(inputValue / roundingIncrement)
    return roundedValue


def get1RM(weight, reps):
    """
    Based upon the passed parameters, project the possible training 1-rep maximum

    Parameters
    --------------------------------------------------------------------------------
        weight : int
            The current weight amount achieved
        reps : int
            The total # of repetitions achieved

    Return
    --------------------------------------------------------------------------------
        The projected 1-rep max
    """
    projected1RM = weight / (100 - (reps * 2.5)) * 100
    roundedProjected1RM = _roundingRule(projected1RM)
    return roundedProjected1RM


def getMuscleSize(bodyPart):
    """
    Based upon the passed parameters, calculate the size the muscle

    Parameters
    --------------------------------------------------------------------------------
        bodyPart : str
            The body part of exercise interest

    Return
    --------------------------------------------------------------------------------
        The size of the muscle being exercised (small, medium, large)
    """
    bodyPartDict = {
    "legs" : "large",
    "back" : "large",
    "chest": "large",
    "shoulder" : "medium",
    "biceps" : "small",
    "triceps" : "small",
    "calves" : "small"
    }
    # idiot-proof body part in case of case mismatches
    bodyPart = bodyPart.lower()
    muscleSize = bodyPartDict[bodyPart]
    return muscleSize


def getWeeklyGain(muscleSize):
    """
    Based upon the passed parameters, identify the size of the muscle

    Parameters
    --------------------------------------------------------------------------------
        muscleSize : str
            The size of the muscle to obtain the weekly gain opportunity

    Return
    --------------------------------------------------------------------------------
        The weekly gain opportunity as a percentage scaled in pounds
    """
    muscleSize = muscleSize.lower()
    if muscleSize == "small":
        weeklyGain = 2.5
    elif muscleSize == "large":
        weeklyGain = 10
    else:
        weeklyGain = 5
    return weeklyGain


def evalGoal(weight, reps, bodyPart, exercise, goalPR, printMessage=True):
    """
    Based upon the passed parameters, evaluate how many weeks to meet the goal PR

    Parameters
    --------------------------------------------------------------------------------
        weight : int
            The size of the muscle to obtain the weekly gain opportunity
        reps : int
            The # of reps achieved at the given weight
        bodyPart : str
            The body part the exercise was performed on
        exercise : str
            The specific exercise to perform the goal on
        goalPR : int
            What the goal Personal Record is desired to be
        printMessage : bool, default True
            Whether or not to print out metric messages
            
    Return
    --------------------------------------------------------------------------------
        Evaluate how many weeks to achieve a new goal Personal Record    
    """
    # translate the bodypart into the muscle size
    muscleSize = getMuscleSize(bodyPart)

    # with the muscle size, scale the weekly strength gain (using appropriate bodypart)
    weeklyGain = getWeeklyGain(muscleSize)

    # calculate the current PR
    currPR = get1RM(weight, reps)

    # establish a start date
    currDate = dt.date.today()

    # create a list to capture the data in tuple form
    tupleList = []

    # iterate over weeks to determine how long it will take to attain the goal PR
    for week, setMax in enumerate(np.arange(currPR, goalPR + weeklyGain * 0.5, weeklyGain)):
        setMax = _roundingRule(setMax)
        workoutDate = currDate + dt.timedelta(weeks=week)
        tupleList.append((week, setMax, workoutDate))

    if printMessage:
        print("Muscle Size: {}\nWeekly Gain: {}\nCurrent PR: {}\nWeeks: {}\nGoal PR: {}".format(muscleSize, 
        weeklyGain, currPR, week, setMax))

        print("You should be able to meet your {} goal PR of {} in {} on {}".format(exercise, goalPR,
            str(dt.timedelta(weeks=week)).split(',')[0], workoutDate))

    return tupleList


def getProgressGraph(tupleList, exercise, figureSize=(8, 8), returnPandas=False):
    """
    Graph progress obtained from evalGoal to show weekly gain and total time

    Parameters
    --------------------------------------------------------------------------------
        tupleList : list
            List of tuples in the form (week, weight, date) of exercise performance data
        exercise : str
            The exercise to graph progress - for chart title
        figureSize : tuple, default (10, 10)
            The size of graph to display (x, y)
        returnPandas : bool, default False
            Whether or not to return the pandas dataframe used to graph the data

    Return
    --------------------------------------------------------------------------------
        A graph visualizing the progress in both weight and time. Optionally the
        pandas dataframe used to graph the results.
    """
    eval_df = pd.DataFrame(tupleList, columns=['week', 'weight', 'date']).astype(
        {'week': int,
         'weight': int,
         'date': np.datetime64})

    # Initialize layout
    fig, ax = plt.subplots(figsize = figureSize)

    # set y and x for regression
    y = eval_df.weight
    x = eval_df.week

    # estimate regression
    b, a = np.polyfit(x, y, deg=1)

    # Plot regression line
    ax.plot(x, a + b * x, color="k", lw=2.5)

    # define catterplot
    ax.scatter(x, y, s=60, alpha=0.7, edgecolors="k")

    # set ticks on each axis
    ax.set_xticks([x_ for x_ in x])
    ax.set_yticks([y_ for y_ in y])

    # provide each axis a title
    ax.set_ylabel("Weight (in Lbs)", fontsize=17)
    ax.set_xlabel("Week (Number)", fontsize=17)
    plt.title("Progress Graph for " + exercise.title(), fontsize=20)

    # add text boxe to indicate the starting point and its associated dates
    plt.text(x[1] - 0.25, y[0], 'Begin Date: ' + 
             dt.date.strftime(eval_df["date"].min(), "%m/%d/%Y"), fontsize=14, 
             bbox = dict(boxstyle="round", facecolor='wheat', alpha=0.5))

    # add text boxe to indicate the ending point and its associated dates
    plt.text(x[5]+0, y[9] * 0.995, 'End Date: ' + 
             dt.date.strftime(eval_df["date"].max(), "%m/%d/%Y"), fontsize=14, 
             bbox = dict(boxstyle="round", facecolor='wheat', alpha=0.5))
    
    plt.xticks(fontsize=12)
    plt.yticks(fontsize=12)
    
    plt.show()

    if returnPandas:
        return eval_df