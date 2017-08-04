@ci
Feature: Edit Main Primary Authority Contact: Load form data - As a Primary Authority Officer
    I need to be able to edit the field 'Main Primary Authority Contact' in the existing partnership details;
    So that the correct details are taken forward into the new PAR

    Background:
        Given I open the url "/user/login"
        And I add "par_authority@example.com" to the inputfield "#edit-name"
        And I add "TestPassword" to the inputfield "#edit-pass"
        When I click on the button "#edit-submit"
        Then I expect that element ".error-message" is not visible

    Scenario: List Partnership Details: Load summary elements Load data into the form
        Given I open the url "/dv/primary-authority-partnerships/1/details"
        Then the element "h1" contains the text "Viewing/confirming partnership details"