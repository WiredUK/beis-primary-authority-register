@ci @Bug @PAR990 @PAR991
Feature: Business User - Update Partnership

    Scenario: Business User - Update Partnership

        #LOGIN

        Given I am logged in as "par_business@example.com"

        # GO TO A PARTNERSHIP PAGE

        And I go to partnership detail page for my partnership "Organisation For Direct Partnership"
       
        # EDIT REGISTERED ADDRESS

        When I edit registered address for organisation

        # EDIT ABOUT THE ORGANISATION

        And I edit about the organisation

        # ADD SIC CODES

        And I change the SIC code

        # ADD EMPLOYEES

        And I change the number of employees

        # ADD NEW TRADING NAME

        And I add and subsequently edit a trading name

        # ADD ORGANISATION CONTACT

        And I add and subsequently edit a organisation contact

        # COMPLETE CHANGES

        When I click on the button "#edit-save"
        And I select the option with the value "confirmed_business" for element "#edit-partnership-status-1"
        And I click on the button "#edit-submit-par-user-partnerships"
        And the element "#block-par-theme-content" contains the text "Organisation For Direct Partnership"