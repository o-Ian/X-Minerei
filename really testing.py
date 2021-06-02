import datetime

import pandas as pd


df = pd.read_csv('Mineration_DATA.ETH/AllData.csv')
df.info()

'''for index, row in df.iterrows():
    row['Date(UTC)'] = datetime.datetime.strptime(row['Date(UTC)'], '%d/%m/%Y').date()
    df.loc[index+1] = [index+1, row['Date(UTC)'] - datetime.timedelta(days=1), 2]'''

