@ci
Feature: Edit About the Partnership: Create form and add to flow - As a Primary Authority Officer
    I need to be able to edit the field 'About the Partnership' in the existing partnership details
    So that the correct details are taken forward into the new PAR

    Background:
        Given I open the url "/user/login"
        And I add "testuser" to the inputfield "#edit-name"
        And I add "testpwd" to the inputfield "#edit-pass"
        When I press "#edit-submit"
        Then I expect that element ".error-message" is not visible

    Scenario: Edit About the Partnership: Create form and add to flow
        Given I open the url "/dv/primary-authority-partnerships/1/partnership/1/details/edit-about"
        Then the element "h1" contains the text "Edit the information about the Partnership"
