import requests
import csv
import json
import pandas as pd
import os


def baixar_arquivo(url, nome_arquivo):
    resultado = requests.get(url, headers={'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) '
                                                         'AppleWebKit/537.36 (HTML, like Gecko) '
                                                         'Chrome/39.0.2171.95 Safari/537.36'})
    with open(nome_arquivo, 'wb') as novo_arquivo:
        novo_arquivo.write(resultado.content)
    novo_arquivo = pd.read_csv(nome_arquivo, usecols=['Date(UTC)', 'Value'], index_col='Date(UTC)')
    arquivo = novo_arquivo.astype('float64')
    novo_arquivo.to_csv(f'{nome_arquivo}')
    return arquivo


def conversorjsontocsv(nome_arquivojson):
    with open(nome_arquivojson) as file:
        data = json.load(file)
    fname = 'Mineration_DATA.ETH/IPCA.csv'
    with open(fname, 'wt') as file:
        csv_file = csv.writer(file)
        csv_file.writerow(['Data', '%IPCA'])
        csv_file = csv.writer(file, lineterminator='\n')
        for item in data:
            csv_file.writerow([item['p'].replace('dezembro', ''), item['v']])
    os.remove(nome_arquivojson)
    return pd.read_csv(fname)


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

# Creating dataset that group all files
AllData = pd.DataFrame(ETHPerDay)

AllData['NetworkDifficulty[TH/s]'] = NetworkDifficulty['Difficulty[TH/s]']
AllData['ETHPriceUSD'] = ETHPriceUSD['ETHPrice_USD']

# Input data from user
HashUsuario = float(input('Qual o seu hashrate [Mh/s]?: '))
Power = int(input('Qual a potência [W]?: '))
SuffixMult = 0.001
PowerCoast = float(input('Qual o tarida de energia [USD]?: '))


# Calculating profit
AllData['ETH/dia'] = (calculateProfit(HashUsuario, AllData['NetworkDifficulty[TH/s]'], AllData['ETHPerDay'])) * 24
AllData['USD_Revenue'] = AllData['ETHPriceUSD'] * AllData['ETH/dia']
AllData['USD_Coast'] = Power * SuffixMult * PowerCoast * 24
AllData['USD_Profit'] = AllData['USD_Revenue'] - AllData['USD_Coast']



# Converting dataset to .csv
AllData.to_csv('Mineration_DATA.ETH/AllData.csv')
# print(pd.read_csv('Mineration_DATA.ETH/AllData.csv').head())
