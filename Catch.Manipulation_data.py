import requests
import csv
import json
import pandas as pd
import os
import numpy as np
import datetime
import os
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By
from selenium import webdriver


def baixar_arquivo(url, nome_arquivo):
    resultado = requests.get(url, headers={'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) '
                                                         'AppleWebKit/537.36 (HTML, like Gecko) '
                                                         'Chrome/39.0.2171.95 Safari/537.36'})
    with open(nome_arquivo, 'wb') as novo_arquivo:
        novo_arquivo.write(resultado.content)
    novo_arquivo = pd.read_csv(nome_arquivo, usecols=['Date(UTC)', 'Value'])
    novo_arquivo['Date(UTC)'] = novo_arquivo['Date(UTC)'].astype('datetime64')
    novo_arquivo['Value'] = novo_arquivo['Value'].astype('float64')
    novo_arquivo.to_csv(f'{nome_arquivo}')
    return novo_arquivo


def conversorjsontocsv(nome_arquivojson):
    with open(nome_arquivojson) as file:
        data = json.load(file)
    fname = 'Mineration_DATA.ETH/IPCA.csv'
    with open(fname, 'wt') as file:
        csv_file = csv.writer(file, lineterminator='\n')
        csv_file.writerow(['Year', '%IPCA'])
        for item in data:
            csv_file.writerow([item['p'].replace('dezembro', ''), item['v']])
    os.remove(nome_arquivojson)
    file = pd.read_csv(fname)
    file['%IPCA'] = file['%IPCA']/100
    file.to_csv('Mineration_DATA.ETH/IPCA.csv')

    return file


def baixar_arquivo2(url, nome_arquivo):
    resultado = requests.get(url, headers={'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) '
                                                         'AppleWebKit/537.36 (HTML, like Gecko) '
                                                         'Chrome/39.0.2171.95 Safari/537.36'})
    with open(nome_arquivo, 'wb') as novo_arquivo:
        novo_arquivo.write(resultado.content)
    return novo_arquivo


def calculateProfit(hashrate_proprio, difficulty, blockreward_dia, fees=1):
    return (((hashrate_proprio*1000000)*(1-((fees)/100)))/(difficulty*1000000000000))*blockreward_dia


# Downloading and renaming files
ETHPerDay = baixar_arquivo('https://etherscan.io/chart/blockreward?output=csv',
                           'Mineration_DATA.ETH/ETHPerDay.csv')
ETHPerDay = ETHPerDay.rename(columns={'Value': 'ETHPerDay'})

NetworkDifficulty = baixar_arquivo('https://etherscan.io/chart/difficulty?output=csv',
                                   'Mineration_DATA.ETH/NetworkDifficulty_TH_s.csv')
NetworkDifficulty = NetworkDifficulty.rename(columns={'Value': 'Difficulty[TH/s]'})

ETHPriceUSD = baixar_arquivo('https://etherscan.io/chart/etherprice?output=csv',
                             'Mineration_DATA.ETH/ETHPrice_USD.csv')
ETHPriceUSD = ETHPriceUSD.rename(columns={'Value': 'ETHPrice_USD'})

baixar_arquivo2('https://servicodados.ibge.gov.br/api/v1/conjunturais?&d=s&user=ibge&t=1737&v=69&p=199512,'
                '199612,199712,199812,199912,200012,200112,200212,200312,200412,200512,200612,200712,200812,'
                '200912,201012, 201112,201212,201312,201412,201512,201612,201712,201812,201912,202012,202112,'
                '202212,202312,202412,202512,202612,202712,202812,202912,203012&ng=1(1)&c=',
                'Mineration_DATA.ETH/IPCA.json')
IPCA = conversorjsontocsv('Mineration_DATA.ETH/IPCA.json')

Date = ETHPerDay['Date(UTC)']

# Creating dataset that group all files
AllData = pd.DataFrame(ETHPerDay)

AllData['NetworkDifficulty[TH/s]'] = NetworkDifficulty['Difficulty[TH/s]']
AllData['ETHPriceUSD'] = ETHPriceUSD['ETHPrice_USD']

# Input data from user
HashUsuario = float(input('Qual o seu hashrate [Mh/s]?: '))
Power = int(input('Qual a potência [W]?: '))
SuffixMult = 0.001
PowerCoast = float(input('Qual o tarida de energia [USD]?: '))
RS_GPUPrice = float(input('Qual o preço da placa de vídeo?: '))

# Recalculating PowerCoast
choicelist = []
c = datetime.date.today().year - 1
cont = len(IPCA)-1
AllData['PowerCoast'] = PowerCoast
for i in range(len(IPCA)):
    if c >= 2015:
        valor = float(IPCA.loc[i + cont, '%IPCA'])
        if c == 2020:
            novo_valor = 1 - valor
            choicelist.append(novo_valor)
        else:
            novo_valor = novo_valor - valor
            choicelist.append(novo_valor)
    cont -= 2
    c -= 1

# Conditional structure for readjustment
condicionlist = [AllData['Date(UTC)'].dt.year == 2020,
                 AllData['Date(UTC)'].dt.year == 2019,
                 AllData['Date(UTC)'].dt.year == 2018,
                 AllData['Date(UTC)'].dt.year == 2017,
                 AllData['Date(UTC)'].dt.year == 2016,
                 AllData['Date(UTC)'].dt.year == 2015]

AllData['Inflação'] = np.select(condicionlist, choicelist, default=1)
AllData['PowerCoast'] = PowerCoast * AllData['Inflação']

# Calculating profit
AllData['ETH/dia'] = (calculateProfit(HashUsuario, AllData['NetworkDifficulty[TH/s]'], AllData['ETHPerDay'])) * 24
AllData['USD_Revenue'] = AllData['ETHPriceUSD'] * AllData['ETH/dia']
AllData['USD_Coast'] = Power * SuffixMult * AllData['PowerCoast'] * 24
AllData['USD_Profit/day'] = AllData['USD_Revenue'] - AllData['USD_Coast']
AllData['USD_Profit/month'] = AllData['USD_Profit/day'] * 30

# Putting together AllData and GPUPrice
AllData['Date(UTC)'] = AllData['Date(UTC)'].astype('datetime64')

GPUPrice = pd.read_csv('Mineration_DATA.ETH/GPUPrice.csv', index_col=0)
GPUPrice['Date(UTC)'] = GPUPrice['Date(UTC)'].astype('datetime64')
del GPUPrice['R$_GPUPrice']

# Activate/Deactivate when the relations between the variables must be done
AllData = pd.merge(AllData, GPUPrice, on='Date(UTC)', how='outer')

# Catching last date from AllData dataframe
last_date = AllData.loc[len(AllData)-1]
last_date = last_date['Date(UTC)']
last_date = str(last_date)

last_date = datetime.datetime.strptime(last_date[:10], '%Y-%m-%d').date()
last_date = last_date.strftime('%m-%d-%Y')

# Downloading dollarPrice.csv
baixar_arquivo2(f"https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial='07-30-2015'&@dataFinalCotacao='{last_date}'&$top=999999999&$format=text/csv", r'Mineration_DATA.ETH/DollarPrice.csv')
dollarPrice2 = pd.read_csv('Mineration_DATA.ETH/DollarPrice.csv')
dollarPrice = pd.DataFrame(columns=['R$_DollarPrice', 'Date(UTC)'])

# Converting dollarPrice columns
dollarPrice['R$_DollarPrice'] = dollarPrice2['cotacaoCompra'].astype('string')
dollarPrice['R$_DollarPrice'] = dollarPrice['R$_DollarPrice'].str.replace(',', '.').astype('float64')
dollarPrice['Date(UTC)'] = dollarPrice2['dataHoraCotacao'].astype('string')

# Taking out hours from Date(UTC) column
dates = dollarPrice['Date(UTC)']
list_data = []
for date in dates:
    list_data.append(date[:10])

dollarPrice['Date(UTC)'] = list_data
dollarPrice['Date(UTC)'] = pd.to_datetime(dollarPrice['Date(UTC)'])

# Putting dollarPrice with AllData dataframe
AllData = pd.merge(AllData, dollarPrice, on='Date(UTC)', how='outer')

# Replacing NaN values to last value from dollarPrice column
AllData['R$_DollarPrice'].fillna(method='ffill', inplace=True)

# Putting Price and Date(UTC) column from AllData on dollarPrice dataframe
dollarPrice['R$_DollarPrice'] = AllData['R$_DollarPrice']
dollarPrice['Date(UTC)'] = AllData['Date(UTC)']

# Putting GPU Price from user on csv file
AllData._set_value(len(AllData)-1, 'R$_GPUPrice', RS_GPUPrice)

# Creating new column (relation between Network Difficulty with the last Network Difficulty)
Last_Difficulty = AllData['NetworkDifficulty[TH/s]'].iloc[-1]
AllData['Multiple_Difficulty/LastDifficulty'] = AllData['NetworkDifficulty[TH/s]']/Last_Difficulty

# Making the prevision of GPU Price
AllData['R$_GPUPrice'] = RS_GPUPrice * AllData['Multiple_GPUPrice']

fill_values = {'R$_GPUPrice': RS_GPUPrice * AllData['Multiple_Difficulty/LastDifficulty']}
AllData.fillna(fill_values, inplace=True)

AllData['R$_GPUPrice'] = RS_GPUPrice * AllData['Multiple_Difficulty/LastDifficulty']

# Conditional structure to use inflation as a multiplicator when date is equal or less than 2017-09-12
condicionlist = [AllData['Date(UTC)'] <= '2017-09-12'
                 ]
choicelist = [AllData['R$_GPUPrice'].loc[775] * AllData['Inflação']
              ]
AllData['R$_GPUPrice'] = np.select(condicionlist, choicelist, default=AllData['R$_GPUPrice'])

# GPU Price conversion (real to dollar)
AllData['USD_GPUPrice'] = AllData['R$_GPUPrice'] / AllData['R$_DollarPrice']

# Column that calcule how much months do you need to pay your investment
AllData['Pays_itself/months'] = AllData['USD_GPUPrice']/AllData['USD_Profit/month']


# Last step
dollarPrice.to_csv('Mineration_DATA.ETH/DollarPrice.csv')
AllData.to_csv('Mineration_DATA.ETH/AllData.csv')
