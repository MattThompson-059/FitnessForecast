import pandas as pd
import datetime as dt
import string


def calcMax(setMax, reps):
    return setMax / (100 - (reps * 2.5)) / 100


def evalGoal(setMax, reps, currPR, goalPR):
    week = 1
    while currPR < goalPR:
        currPR = calcMax(setMax, reps)
        week += 1
        setMax = setMax + setMax * 0.025
    goalPR = setMax
    print("You will be able to meet the goal by: ", dt.timedelta(weeks=week))
    return goalPR


if __name__ == "__main__":
    # read in the data
    dataset = pd.read_csv('weightProjectionExampleDataset.csv', header=0)

    # print(dataset)
    # print(dataset[['Exercise', 'MaxWeightSet']].iloc[1])

    # saves the exercises names to check the single rep maximum
    exerciseList = dataset['Exercise'].to_string(index=False)
    # maxList = dataset['MaxWeightSet'].to_string(index=False)
    # repList = dataset['Reps'].to_string(index=False)
    # currPRList = dataset['CurrentPR'].to_string(index=False)

    # print(exerciseList)

    # saving the dataset names for future use
    dataset_list = list(dataset.columns)

    # initialize columns
    setMax, oneRepMax, reps, goalPR, currPR, projPR = 0, 0, 0, 0, 0, 0
    currWeek = 1
    datePR = dt.date.today()
    projDatePR = dt.date.today()

    chooseExercise = string.capwords(str(input("Which exercise do you want to evaluate?\n")))

    # var = dataset.loc[chooseExercise]
    # print(var)
    # tomato = dataset.set_index(['MaxWeightSet'])
    # print(tomato)

    # dataset.iloc[index][col]

    if chooseExercise in exerciseList:
        if goalPR > projPR:
            print("It may take more time to achieve your goal based on your current maximum set weight.")
            evalGoal(setMax, reps, currPR, goalPR)
        elif goalPR < projPR:
            print("Your goal is achievable when you're ready to attempt it.")
        else:
            print("You may want to increase your goal weight to aim for.")