import pandas as pd
import datetime
import os
import numpy as np
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By
from selenium import webdriver
from time import sleep


def inserir_linha(idx, df, df_inserir):
    dfA = df.iloc[:idx, ]
    dfB = df.iloc[idx:, ]

    df = dfA.append(df_inserir).append(dfB).reset_index(drop=True)

    return df


ExistFile = False

if os.path.isfile('Mineration_DATA.ETH/GPUPrice.csv'):
    ExistFile = True
    GPUPricePast = pd.read_csv('Mineration_DATA.ETH/GPUPrice.csv')
    LastDate = GPUPricePast.loc[len(GPUPricePast)-1]
    LastDate = LastDate['Date(UTC)']
    LastDate = datetime.datetime.strptime(LastDate, '%Y-%m-%d').date()

option = Options()
option.headless = False
driver = webdriver.Firefox(executable_path=r'./geckodriver.exe')
driver.get('https://vigiadepreco.com.br/p/4712900927290/')
driver.maximize_window()
action = webdriver.ActionChains(driver)
sleep(7)


# Close the window that apper in the beggin
closeprog = WebDriverWait(driver, 20).until(EC.element_to_be_clickable((By.XPATH, '//*[@id="__layout"]/div/main/div[1]/div/div/div[2]/button/img')))
closeprog.click()

# Click on 1 year button
yearbutton = WebDriverWait(driver, 20).until(EC.element_to_be_clickable((By.XPATH, '//*[@id="historico"]/div/div[2]/div[1]/div/div[2]/div[1]/div[1]')))
yearbutton.click()

# Locate the graph and know his size
graph = WebDriverWait(driver, 20).until(EC.presence_of_element_located((By.CSS_SELECTOR, '#historico > div > div.graph.pb-5 > div.__ext-graph > div > svg > g.cnt-graph > g.cnt-graph')))
loc = graph.location
size = graph.size

# Move the mouse to graph begin
action.move_to_element_with_offset(graph, 1127.0999755859375, 0).perform()

# Creating DataFrame
GPUPrice = pd.DataFrame(columns=['Date(UTC)', 'R$ Price'])

# Moving mouse and catching data
limit = datetime.datetime.strptime('20/12/2020', '%d/%m/%Y').date()
pace = -13
while True:
    action.move_by_offset(pace, 0).perform()
    valor = driver.find_element_by_css_selector('#historico > div > div.graph.pb-5 > div.__ext-graph > div > svg > g.cnt-tooltip > g > text:nth-child(1)').text
    valor = str(valor)
    date = driver.find_element_by_css_selector('#historico > div > div.graph.pb-5 > div.__ext-graph > div > svg > g.cnt-tooltip > g > text:nth-child(2)').text
    date = datetime.datetime.strptime(date[3:], '%d/%m/%Y').date()
    if ExistFile:
        if date <= LastDate:
            break
    else:
        if date <= limit:
            break
    GPUPrice.loc[len(GPUPrice)] = [date, valor[3:].replace('.', '').replace(',', '.')]
driver.quit()

# Converting columns
GPUPrice['R$ Price'] = GPUPrice['R$ Price'].astype('float64')
GPUPrice['Date(UTC)'] = GPUPrice['Date(UTC)'].astype('datetime64')

# Transforming GPUPrice['Date(UTC)'] in a list
datas = GPUPrice['Date(UTC)']
list_datas = []
for linhas in datas:
    list_datas.append(linhas)

# Transforming GPUPrice['R$ Price'] in a list
price = GPUPrice['R$ Price']
list_price = []
for value in price:
    list_price.append(value)

# Adding date that foul
c = 1
cont = 0
for index in range(0, len(GPUPrice)-1):
    d_iserido = {'Date(UTC)': [list_datas[cont] - datetime.timedelta(days=1)],
                 'R$ Price': [(list_price[cont]+list_price[c])/2]}
    df_iserido = pd.DataFrame(data=d_iserido)
    GPUPrice = inserir_linha(index+c, GPUPrice, df_iserido)
    c += 1
    cont += 1

# Formatting dataframe
GPUPrice2 = pd.DataFrame(columns=['Date(UTC)', 'R$_GPUPrice'])

GPUPrice2['Date(UTC)'] = GPUPrice['Date(UTC)']
GPUPrice2['R$_GPUPrice'] = GPUPrice['R$ Price']

GPUPrice2.sort_values(by=['Date(UTC)'], ignore_index=True, inplace=True)

# Creating Multiple_GPUPrice column, a comparison from last price to others
LastPriceGPU = GPUPrice2['R$_GPUPrice'].iloc[-1]

# Removing useless file
if os.path.isfile('geckodriver.log'):
    os.remove('geckodriver.log')

if ExistFile:
    GPUPrice3 = pd.DataFrame(columns=['Date(UTC)', 'R$_GPUPrice', 'Multiple_GPUPrice'])
    GPUPrice2 = pd.concat([GPUPricePast, GPUPrice2], ignore_index=True)
    GPUPrice3['Date(UTC)'] = GPUPrice2['Date(UTC)']
    GPUPrice3['R$_GPUPrice'] = GPUPrice2['R$_GPUPrice']
    GPUPrice3['Date(UTC)'] = GPUPrice3['Date(UTC)'].astype('datetime64')
    GPUPrice2['Multiple_GPUPrice'] = GPUPrice2['R$_GPUPrice'] / LastPriceGPU
    GPUPrice3['Multiple_GPUPrice'] = GPUPrice2['Multiple_GPUPrice']
    # Converting dataframe to .csv file
    GPUPrice3.to_csv('Mineration_DATA.ETH/GPUPrice.csv')

else:
    # Converting dataframe to .csv file
    GPUPrice2['Multiple_GPUPrice'] = GPUPrice2['R$_GPUPrice'] / LastPriceGPU
    GPUPrice2.to_csv('Mineration_DATA.ETH/GPUPrice.csv')
