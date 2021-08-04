# -*- coding: utf-8 -*-
import csv

import pandas as pd
import pymysql
from config import config

cnx = pymysql.connect(**config, charset='utf8')  # Conexão
cursor = cnx.cursor()  # Executar as querys

input_file = csv.DictReader(open("Mineration_DATA.ETH/AllData.csv", encoding='utf-8'))
cursor.execute("delete from mineration_data")
for row in input_file:
    cursor.execute("insert into mineration_data (data_utc, ethperday, networkDifficulty, ethPrice_usd, ethPrice_BRL,"
                   "inflacao, indicador, "
                   "multiple_gpuPrice, R$_DollarPrice, Difficulty_LastDifficulty) \
                values (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                   (row['Date(UTC)'], row['ETHPerDay'], row['NetworkDifficulty[TH/s]'], row['ETHPriceUSD'],
                    row['ETHPriceBRL'], row['Inflação'], row['Indicador'], row['Multiple_GPUPrice'],
                    row['R$_DollarPrice'], row['Multiple_Difficulty/LastDifficulty']))
    cnx.commit()
