import datetime

import pandas as pd


'''GPUPrice = pd.read_csv('Mineration_DATA.ETH/GPUPrice.csv', index_col=0)
AllData = pd.read_csv('Mineration_DATA.ETH/AllData.csv', index_col=0)
df_teste = pd.merge(AllData, GPUPrice, on='Date(UTC)', how='outer')
df_teste.to_csv('Mineration_DATA.ETH/TESTE.csv')
'''
df = pd.read_csv('Mineration_DATA.ETH/GPUPrice.csv')
df.info()
