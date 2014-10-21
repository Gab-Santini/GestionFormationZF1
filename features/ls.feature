Feature: Homepage
  In order to know ZF works with Behat
  I need to see that the page loads.

Scenario: Check the homepage
  Given I load the URL "/"
  Then the controller should be "index"
  And the action should be "admin"
  And the action should not redirect
  And the page should contain a "title" tag that contains "My Nifty ZF App"