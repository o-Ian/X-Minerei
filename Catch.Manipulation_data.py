import numpy
import requests
import csv
import json
import pandas as pd
import os
import numpy as np
import datetime
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

def infoGrafico(url):
    option = Options()
    option.headless = False
    driver = webdriver.Chrome(options=option)
    driver.get(url)
    driver.maximize_window()

    action = webdriver.ActionChains(driver)

    search_1year = WebDriverWait(driver, 20).until(EC.element_to_be_clickable((By.XPATH, '/html/body/div/div/div/main/div[4]/div/div[2]/div/div[2]/div[1]/div/div[2]/div[1]')))
    search_1year.click()

    graph = WebDriverWait(driver, 20).until(EC.presence_of_element_located((By.XPATH, '/html/body/div/div/div/main/div[4]/div/div[2]/div/div[2]/div[1]/div/svg/g[2]')))
    loc = graph.location
    size = graph.size

    print(loc)


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

# Condicional structure for readjustment
condicionlist = [AllData['Date(UTC)'].dt.year == 2020,
                 AllData['Date(UTC)'].dt.year == 2019,
                 AllData['Date(UTC)'].dt.year == 2018,
                 AllData['Date(UTC)'].dt.year == 2017,
                 AllData['Date(UTC)'].dt.year == 2016,
                 AllData['Date(UTC)'].dt.year == 2015]

AllData['Múltiplo'] = np.select(condicionlist, choicelist, default=1)
AllData['PowerCoast'] = PowerCoast * AllData['Múltiplo']
# Calculating profit
AllData['ETH/dia'] = (calculateProfit(HashUsuario, AllData['NetworkDifficulty[TH/s]'], AllData['ETHPerDay'])) * 24
AllData['USD_Revenue'] = AllData['ETHPriceUSD'] * AllData['ETH/dia']
AllData['USD_Coast'] = Power * SuffixMult * AllData['PowerCoast'] * 24
AllData['USD_Profit'] = AllData['USD_Revenue'] - AllData['USD_Coast']

# Converting dataset to .csv
AllData.to_csv('Mineration_DATA.ETH/AllData.csv')
