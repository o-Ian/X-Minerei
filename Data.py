import requests
import pandas as pd


def baixar_arquivo(url, nome_arquivo):
    resultado = requests.get(url, headers={'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) '
                                                         'AppleWebKit/537.36 (HTML, like Gecko) '
                                                         'Chrome/39.0.2171.95 Safari/537.36'})
    with open(nome_arquivo, 'wb') as novo_arquivo:
        novo_arquivo.write(resultado.content)
    novo_arquivo = pd.read_csv(nome_arquivo, usecols=['Date(UTC)', 'Value'], index_col='Date(UTC)')
    novo_arquivo.to_csv(f'{nome_arquivo}')


baixar_arquivo('https://etherscan.io/chart/hashrate?output=csv', 'Mineration_DATA.ETH/HashRateTotal.csv')
baixar_arquivo('https://etherscan.io/chart/blockreward?output=csv', 'Mineration_DATA.ETH/ETHPerDay.csv')


