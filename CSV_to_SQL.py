# -*- coding: utf-8 -*-
import csv

import pandas as pd
import pymysql
from config import config

cnx = pymysql.connect(**config, charset='utf8')  # Conexão
cursor = cnx.cursor()  # Executar as querys

input_file = csv.DictReader(open("Mineration_DATA.ETH/AllData.csv", encoding='utf-8'))

for row in input_file:
    cursor.execute("insert into mineration_data (data_utc, ethperday, networkDifficulty, ethPrice_usd, Power_cost, "
                   "inflacao, eth_dia, usd_revenue, usd_cost, usd_profit_day, usd_profit_month, indicador, "
                   "multiple_gpuPrice, R$_DollarPrice, R$_GPUPrice, Difficulty_LastDifficulty, USD_GPUPrice, "
                   "Pays_itself_months) \
    values (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                   (row['Date(UTC)'], row['ETHPerDay'], row['NetworkDifficulty[TH/s]'], row['ETHPriceUSD'], row['PowerCoast'],
                    row['Inflação'], row['ETH/dia'], row['USD_Revenue'], row['USD_Coast'], row['USD_Profit/day'],
                    row['USD_Profit/month'],
                    row['Indicador'], row['Multiple_GPUPrice'], row['R$_DollarPrice'], row['R$_GPUPrice'],
                    row['Multiple_Difficulty/LastDifficulty'], row['USD_GPUPrice'], row['Pays_itself/months']))
    cnx.commit()
