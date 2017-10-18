@Pending
Feature: Business User - Manage Addresses

    Scenario: Business User - Manage Addresses

        # PARTNERSHIPS DASHBOARD

#        Given I reset the test data
        Given I am logged in as "par_business@example.com"
        And I open the url "/dashboard"
        And I click on the link "See your partnerships"
        And I click on the link "Business For Direct Partnership 1"
        And I reload the page
        And I expect that element "h1" is not empty

        # EDIT REGISTERED ADDRESS

        When  I click on the link "edit address"
        And I clear the inputfield "#edit-address-line1"
        And I clear the inputfield "#edit-address-line2"
        And I clear the inputfield "#edit-town-city"
        And I clear the inputfield "#edit-postcode"
        And I clear the inputfield "#edit-county"
        And I click on the button "#edit-save"
        Then I expect that element ".error-summary" does exist
        When I add "SE16 4NX" to the inputfield "#edit-postcode"
        And I click on the button "#edit-save"
        Then I expect that element ".error-summary" does exist
        And I add "1 Change St" to the inputfield "#edit-address-line1"
        And I click on the button "#edit-save"
        Then I expect that element ".error-summary" does exist
        And I add "New Change" to the inputfield "#edit-address-line2"
        And I click on the button "#edit-save"
        Then I expect that element ".error-summary" does exist
        When I add "London" to the inputfield "#edit-town-city"
        When I add "London" to the inputfield "#edit-county"
        And I select the option with the text "England" for element "#edit-country"
        When I click on the button "#edit-save"
        Then I expect that element "#edit-registered-address" contains the text "1 Change St"
        And I expect that element "#edit-registered-address" contains the text "New Change"
        And I expect that element "#edit-registered-address" contains the text "London"
        And I expect that element "#edit-registered-address" contains the text "SE16 4NX"

        # EDIT ABOUT THE BUSINESS

        When I click on the link "edit about the organisation"
        And I add "Change to the about business details section" to the inputfield "#edit-about-business"
        And I click on the button "#edit-save"
        Then I expect that element "#edit-about-business" contains the text "Change to the about business details section"

        # ADD SIC CODES

        When I click on the link "add another sic code"
        And I select the option with the text "10-0 Health and social care" for element "#edit-sic-code"
        And I click on the button "#edit-save"
        Then I expect that element "#edit-sic-codes" contains the text "Health and social care"

        # ADD EMPLOYEES

        When I click on the link "edit number of employees"
        And I select the option with the text "50-249" for element "#edit-employees-band"
        And I click on the button "#edit-save"
        Then I expect that element "#edit-employee-no" contains the text "50-249"

        # EDIT LEGAL ENTITY

#        When I click on the link "edit legal entity"
#        And I clear the inputfield "#edit-registered-name"
#        When I add "Changed" to the inputfield "#edit-registered-name"
#        And I select the option with the text "Limited Company" for element "#edit-legal-entity-type"
#        And I clear the inputfield "#edit-company-house-no"
#        When I add "0123456789" to the inputfield "#edit-company-house-no"
#        And I click on the button "#edit-save"
#        Then I expect that element "#edit-legal-entities" contains the text "Changed"
#        Then I expect that element "#edit-legal-entities" contains the text "Limited Company"

        # ADD LEGAL ENTITY

#        When I click on the link "add another legal entity"
#        When I add "New Legal Entity" to the inputfield "#edit-registered-name"
#        And I select the option with the text "Partnership" for element "#edit-legal-entity-type"
#        And I click on the button "#edit-save"
#        Then I expect that element "#edit-legal-entities" contains the text "New Legal Entity"
#        Then I expect that element "#edit-legal-entities" contains the text "Partnership"

        # ADD NEW TRADING NAME

        When I click on the link "add another trading name"
        When I add "Different Trading Name" to the inputfield "#edit-trading-name"
        And I click on the button "#edit-save"
        Then I expect that element "#edit-trading-names" contains the text "Different Trading Name"

        # EDIT MAIN BUSINESS CONTACT

#        When I click on the link "edit organisation contact"
        And I click on the button "/html/body/main/div[2]/div[4]/form/div[13]/fieldset/div[2]/fieldset/a"
        And I add "Harvey" to the inputfield "#edit-first-name"
        And I add "Kneeslapper" to the inputfield "#edit-last-name"
        And I add "999999999" to the inputfield "#edit-work-phone"
        And I add "1111111111111" to the inputfield "#edit-mobile-phone"
        And I add "02079999999" to the inputfield "#edit-work-phone"
        And I add "078659999999" to the inputfield "#edit-mobile-phone"
        And I add "bb0b6a4fb855c1dbac76e3c31a71a406@localhost.localdomain" to the inputfield "#edit-email"
        And I click on the radio "#edit-preferred-contact-communication-mobile"
        And I add "Some additional notes" to the inputfield "#edit-notes"
        And I click on the button "#edit-save"
        Then I expect that element "#edit-organisation-contacts" contains the text "Harvey"
        And I expect that element "#edit-organisation-contacts" contains the text "Kneeslapper"
        And I expect that element "#edit-organisation-contacts" contains the text "bb0b6a4fb855c1dbac76e3c31a71a406@localhost.localdomain"
        And I expect that element "#edit-organisation-contacts" contains the text "2079999999"
        And I expect that element "#edit-organisation-contacts" contains the text "78659999999"
        And I click on the checkbox "#edit-partnership-info-agreed-business"

        # COMPLETE CHANGES

        And I click on the button "#edit-done"
        Then I expect that element "h1" contains the text "Primary Authority Register"