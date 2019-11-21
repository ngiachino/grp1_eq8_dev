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
  def setup_method(self):
    self.driver = webdriver.Chrome()
    self.vars = {}
  
  def teardown_method(self):
    self.driver.quit()
  
  def test_connexionDeconnexion(self):
    self.driver.get("http://localhost/CDP/app/")
    self.driver.set_window_size(1900, 1020)
    self.driver.find_element(By.ID, "nameCo").click()
    self.driver.find_element(By.ID, "nameCo").send_keys("TestAccount")
    self.driver.find_element(By.ID, "pswdCo").click()
    self.driver.find_element(By.ID, "pswdCo").send_keys("test")
    self.driver.find_element(By.NAME, "submitCo").click()
    self.driver.find_element(By.LINK_TEXT, "Se déconnecter").click()
  
