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

class TestIssueAddDelete(unittest.TestCase):
  def setUp(self):
    self.driver = webdriver.Chrome(executable_path='chromedriver.exe')
    self.vars = {}

  def test_issueAddDelete(self):
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
    self.driver.find_element(By.CSS_SELECTOR, ".d-inline-block").click()
    time.sleep(5)
    self.driver.find_element(By.ID, "issues").click()
    time.sleep(5)
    self.driver.find_element(By.NAME, "description").click()
    self.driver.find_element(By.NAME, "description").send_keys("Issue Test")
    self.driver.find_element(By.NAME, "priority").click()
    dropdown = self.driver.find_element(By.NAME, "priority")
    dropdown.find_element(By.XPATH, "//option[. = 'Medium']").click()
    self.driver.find_element(By.NAME, "priority").click()
    self.driver.find_element(By.NAME, "difficulty").click()
    self.driver.find_element(By.NAME, "difficulty").send_keys("1")
    self.driver.find_element(By.NAME, "difficulty").click()
    self.driver.find_element(By.NAME, "difficulty").send_keys("2")
    self.driver.find_element(By.NAME, "difficulty").click()
    self.driver.find_element(By.NAME, "submit").click()
    time.sleep(5)
    self.driver.find_element(By.ID,"delete1").click()

  def tearDown(self):
    self.driver.quit()
