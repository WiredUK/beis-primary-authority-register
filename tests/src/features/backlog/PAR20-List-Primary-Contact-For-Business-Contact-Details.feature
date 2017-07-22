@Pending
Feature: As a Primary Authority Officer,
    I need to be able to see the main contact for the business, and their contact details,
    So that I can contact them.

    Background:
        Given I open the url "/login"
        And I add "PrimaryAuthority" to the inputfield "#username"
        And I add "password" to the inputfield "#password"
        And I press "Login"
        Then the element "#logged-in-header" contains the text "Logged in"

        Scenario:
            Then the element "h1" contains the text "You need to review and confirm the following partnerships"
            And the element "#your-partnerships" does exist
            And the element "#partnership-status" does exist
            When I click on the link "#partnership-1"
            Then the element "#tasks-list" contains the text "Your tasks"
            And the element "#main-contact" contains the text "Main contact"

