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


ETHPerDay = baixar_arquivo('https://etherscan.io/chart/blockreward?output=csv',
                           'Mineration_DATA.ETH/ETHPerDay.csv')
ETHPerDay = ETHPerDay.rename(columns={'Value': 'ETHPerDay'})
NetWorkHash = baixar_arquivo('https://etherscan.io/chart/hashrate?output=csv',
                             'Mineration_DATA.ETH/NetworkHash_GH_s.csv')
NetWorkHash = NetWorkHash.rename(columns={'Value': 'Hashrate/day[GH/s]'})
AllData = pd.DataFrame(ETHPerDay)
AllData['Hashrate/dia[GH/s]'] = NetWorkHash['Hashrate/day[GH/s]']

HashUsuario = float(input('Qual o seu hashrate [Mh/s]? '))/1000

AllData['HashUsuario_network'] = (HashUsuario / AllData['Hashrate/dia[GH/s]'])
AllData['HashUsuario_network % '] = (HashUsuario / AllData['Hashrate/dia[GH/s]']) * 100
AllData['ETHMined'] = AllData['ETHPerDay'] * AllData['HashUsuario_network']
AllData.to_csv('Mineration_DATA.ETH/AllData.csv')
print(pd.read_csv('Mineration_DATA.ETH/AllData.csv'))
