import pytest
import time
import json
import unittest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support import expected_conditions
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.common.keys import Keys

class TestConnexionDeconnexion(unittest.TestCase):
  def setUp(self):
    self.driver = webdriver.Chrome(executable_path='chromedriver.exe')
    self.vars = {}
  
  def test_connexionDeconnexion(self):
    with open('url.txt', 'r') as file:
      url = file.read().replace('\n', '')

    self.driver.get(url)
    self.driver.set_window_size(1900, 1020)
    time.sleep(5)
    self.driver.find_element(By.ID, "nameCo").click()
    self.driver.find_element(By.ID, "nameCo").send_keys("TestAccountSelenium")
    self.driver.find_element(By.ID, "pswdCo").click()
    self.driver.find_element(By.ID, "pswdCo").send_keys("test")
    self.driver.find_element(By.NAME, "submitCo").click()
    time.sleep(5)
    self.driver.find_element(By.LINK_TEXT, "Se déconnecter").click()

  def tearDown(self):
    self.driver.quit()
