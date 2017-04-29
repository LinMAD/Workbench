Feature: Create a serial via API
  In order to create serial
  As an Api user
  I need to be able to make request with specific data and create a new serial

  Scenario: Create a serial
    Given I have the payload:
  """
  {
    "name":"Behat_serial",
    "description":"TESTING TOOOL",
    "genre":"TEST",
    "rating":5,
    "seasons":2
  }
  """
    When I request "POST http://localhost/app_dev.php/api/serials"
    Then the response status code should be 201
    And the "name" property should equal "Behat_serial"