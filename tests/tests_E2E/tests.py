import pytest
import time
import json
import unittest
import sys
import time
import os
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support import expected_conditions
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.common.keys import Keys

import test_ConnexionDeconnexion
import test_issueAddDelete
import test_memberAddDelete
import test_releaseClickOnLink
import test_sprintAddModifyDelete

def main(out):
    suite = unittest.TestSuite()
    suite.addTest(unittest.makeSuite(test_ConnexionDeconnexion.TestConnexionDeconnexion))
    suite.addTest(unittest.makeSuite(test_issueAddDelete.TestIssueAddDelete))
    suite.addTest(unittest.makeSuite(test_memberAddDelete.TestMemberAddDelete))
    suite.addTest(unittest.makeSuite(test_releaseClickOnLink.TestReleaseClickOnLink))
    suite.addTest(unittest.makeSuite(test_sprintAddModifyDelete.TestSprintAddModifyDelete))
    unittest.TextTestRunner(out,verbosity = 3).run(suite)

if __name__ == '__main__': 
    with open('latest_log.txt', 'w') as out:
        main(out)
