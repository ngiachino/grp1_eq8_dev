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

class TestReleaseAddModifyDelete(unittest.TestCase):
  def setup_method(self):
    self.driver = webdriver.Chrome()
    self.vars = {}
  
  def teardown_method(self):
    self.driver.quit()
  
  def test_releaseAddModifyDelete(self):
    self.driver.get("http://localhost/CDP/app/")
    self.driver.set_window_size(1900, 1020)
    self.driver.find_element(By.ID, "nameCo").click()
    self.driver.find_element(By.ID, "nameCo").send_keys("TestAccount")
    self.driver.find_element(By.ID, "pswdCo").click()
    self.driver.find_element(By.ID, "pswdCo").send_keys("test")
    self.driver.find_element(By.NAME, "submitCo").click()
    self.driver.find_element(By.CSS_SELECTOR, ".d-inline-block").click()
    self.driver.find_element(By.LINK_TEXT, "Les releases").click()
    self.driver.find_element(By.NAME, "version").click()
    self.driver.find_element(By.NAME, "version").send_keys("1.0")
    self.driver.find_element(By.NAME, "lien").click()
    self.driver.find_element(By.NAME, "lien").send_keys("https://github.com/ngiachino/grp1_eq8_dev/releases/tag/0.1.0")
    self.driver.find_element(By.NAME, "description").click()
    self.driver.find_element(By.NAME, "description").send_keys("Seconde Release")
    self.driver.find_element(By.NAME, "date").click()
    self.driver.find_element(By.NAME, "date").send_keys("2019-11-21")
    self.driver.find_element(By.NAME, "submit").click()
    self.driver.find_element(By.CSS_SELECTOR, "tr:nth-child(2) > td > .btn").click()
    self.driver.find_element(By.ID, "modifyReleaseModal19").click()
    self.driver.find_element(By.CSS_SELECTOR, "#modifyReleaseModal19 #releaseVersion").send_keys("0.2")
    self.driver.find_element(By.CSS_SELECTOR, "#modifyReleaseModal19 .btn-primary").click()
    self.driver.find_element(By.CSS_SELECTOR, "tr:nth-child(2) form > .btn").click()
  
