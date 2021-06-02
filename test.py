import requests
import csv
import json
import pandas as pd
import os
import numpy as np
import datetime

from selenium.webdriver import DesiredCapabilities
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By
from selenium import webdriver
from time import sleep

option = Options()
option.headless = False
driver = webdriver.Firefox(executable_path=r'./geckodriver.exe')
driver.get('https://vigiadepreco.com.br/p/4712900927290/')
driver.maximize_window()
action = webdriver.ActionChains(driver)
sleep(10)
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

# Moving mouse and catching data

limit = 'em 02/05/2021'
pace = -5
while True:
    action.move_by_offset(pace, 0).perform()
    valor = driver.find_element_by_css_selector('#historico > div > div.graph.pb-5 > div.__ext-graph > div > svg > g.cnt-tooltip > g > text:nth-child(1)').text
    date = driver.find_element_by_css_selector('#historico > div > div.graph.pb-5 > div.__ext-graph > div > svg > g.cnt-tooltip > g > text:nth-child(2)').text
    date = datetime.datetime.strptime(date[3:], '%d/%m/%Y').date()


driver.quit()
print(loc)
print(size)
print(valor)
print(date)
print(type(date))
