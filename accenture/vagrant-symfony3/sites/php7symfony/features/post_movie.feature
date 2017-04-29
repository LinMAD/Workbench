Feature: Create a movie via API
  In order to create movie
  As an Api user
  I need to be able to make request with specific data and create a new movie

  Scenario: Create a movie
    Given I have the payload:
  """
  {
    "name": "Leon",
    "description" : "Little girl ruins the life of professional hitman",
    "genre": "action",
    "rating" : 5
  }
  """
    When I request "POST http://localhost/app_dev.php/api/movies"
    Then the response status code should be 201
    And the "name" property should equal "Leon"