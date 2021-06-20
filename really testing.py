import datetime
import os
import pandas as pd

AllData = pd.read_csv('Mineration_DATA.ETH/AllData.csv', index_col=0)

print(AllData['R$_GPUPrice'].loc[775])

