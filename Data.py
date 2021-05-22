import requests
import pandas as pd


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


def calculateProfit(hashrate_proprio, difficulty, blockreward_dia, fees=1):
    return (((hashrate_proprio*1000000)*(1-((fees)/100)))/(difficulty*1000000000000))*blockreward_dia


# Downloading and renaming files
ETHPerDay = baixar_arquivo('https://etherscan.io/chart/blockreward?output=csv',
                           'Mineration_DATA.ETH/ETHPerDay.csv')
ETHPerDay = ETHPerDay.rename(columns={'Value': 'ETHPerDay'})

NetworkDifficulty = baixar_arquivo('https://etherscan.io/chart/difficulty?output=csv',
                                   'Mineration_DATA.ETH/NetworkDifficulty_TH_s.csv')
NetworkDifficulty = NetworkDifficulty.rename(columns={'Value': 'Difficulty[TH/s]'})

# Creating dataset that group all files
AllData = pd.DataFrame(ETHPerDay)
AllData['NetworkDifficulty[TH/s]'] = NetworkDifficulty['Difficulty[TH/s]']

HashUsuario = float(input('Qual o seu hashrate [Mh/s]? '))

# Calculating profit
AllData['ETH/hora'] = calculateProfit(HashUsuario, AllData['NetworkDifficulty[TH/s]'], AllData['ETHPerDay'])
AllData['ETH/dia'] = AllData['ETH/hora'] * 24

# Converting dataset to .csv
AllData.to_csv('Mineration_DATA.ETH/AllData.csv')
print(pd.read_csv('Mineration_DATA.ETH/AllData.csv'))
