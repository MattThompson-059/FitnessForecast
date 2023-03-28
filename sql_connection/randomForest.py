import pandas as pd
import numpy as np

# read in the data 
steve_harvey = pd.read_csv('routineData.csv')
	
# show me data!
steve_harvey.head(12)

# talks about each column
steve_harvey.describe()


