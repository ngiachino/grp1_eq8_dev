# Generated by Selenium IDE
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

class TestMemberAddDelete(unittest.TestCase):
  def setup_method(self):
    self.driver = webdriver.Chrome()
    self.vars = {}
  
  def teardown_method(self):
    self.driver.quit()
  
  def test_memberAddDelete(self):
    self.driver.get("http://localhost/CDP/app/")
    self.driver.set_window_size(1900, 1020)
    self.driver.find_element(By.ID, "nameCo").click()
    self.driver.find_element(By.ID, "nameCo").send_keys("TestAccount")
    self.driver.find_element(By.ID, "pswdCo").click()
    self.driver.find_element(By.ID, "pswdCo").send_keys("test")
    self.driver.find_element(By.NAME, "submitCo").click()
    self.driver.find_element(By.CSS_SELECTOR, ".d-inline-block").click()
    self.driver.find_element(By.ID, "userName").click()
    self.driver.find_element(By.ID, "userName").send_keys("TestAccount2")
    self.driver.find_element(By.NAME, "submit").click()
    self.driver.find_element(By.LINK_TEXT, "Se déconnecter").click()
    self.driver.find_element(By.ID, "nameCo").click()
    self.driver.find_element(By.ID, "nameCo").send_keys("TestAccount")
    self.driver.find_element(By.ID, "nameCo").send_keys("TestAccount2")
    self.driver.find_element(By.ID, "pswdCo").click()
    self.driver.find_element(By.ID, "pswdCo").click()
    self.driver.find_element(By.ID, "pswdCo").send_keys("test")
    self.driver.find_element(By.NAME, "submitCo").click()
    self.driver.find_element(By.CSS_SELECTOR, ".tdProject").click()
    self.driver.find_element(By.CSS_SELECTOR, ".d-inline-block").click()
    self.driver.find_element(By.NAME, "deleteUser").click()
    self.driver.find_element(By.LINK_TEXT, "Se déconnecter").click()
    self.driver.find_element(By.ID, "nameCo").click()
    self.driver.find_element(By.ID, "nameCo").send_keys("TestAccount")
    self.driver.find_element(By.ID, "pswdCo").click()
    self.driver.find_element(By.ID, "pswdCo").send_keys("test")
    self.driver.find_element(By.NAME, "submitCo").click()
    self.driver.find_element(By.CSS_SELECTOR, ".d-inline-block").click()
  
