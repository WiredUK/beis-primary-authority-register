@ci @userjourney1
Feature: User Journey 1 (happy path)

    Background:
        Given I open the url "/user/login"
        And I add "dadmin" to the inputfield "#edit-name"
        And I add "password" to the inputfield "#edit-pass"
        And I click on the button "#edit-submit"
        And I open the url "/admin/par-data-test-reset"
        And I open the url "/user/logout"

    Scenario: User Journey 1 - Change partnership details
        # HOMEPAGE
        Given I open the url "/user/login"
        # LOGIN SCREEN
        And I add "par_authority@example.com" to the inputfield "#edit-name"
        And I add "TestPassword" to the inputfield "#edit-pass"
        When I click on the button "#edit-submit"
        # WELCOME SCREEN
        Then I expect that element ".error-message" is not visible
        When I click on the button ".button-start"
        # PARTNERSHIPS DASHBOARD
        And I click on the link "ABCD Mart"
        # TERMS AND CONDITIONS SCREEN
        And I click on the checkbox "#edit-terms-conditions"
        And I click on the button "#edit-next"
        When I click on the link "Review and confirm your partnership details"
        # REVIEW PARTNERSHIPS DETAILS
        And I click on the link "edit"
        And I add "test partnership info change" to the inputfield "#edit-about-partnership"
        And I click on the button "#edit-next"
        Then the element "#edit-first-section" contains the text "test partnership info change"
        When I click on the button "html.js body.js-enabled main#content div div#block-par-theme-content form#par-flow-transition-partnership-details-overview.par-flow-transition-partnership-details-overview div fieldset#edit-authority-contacts.js-form-item.form-item.js-form-wrapper.form-wrapper.inline em.placeholder a.flow-link"
        And I add "Animal" to the inputfield "#edit-first-name"
        And I add "the Muppet" to the inputfield "#edit-last-name"
        And I add "91723456789" to the inputfield "#edit-work-phone"
        And I add "9777777777" to the inputfield "#edit-mobile-phone"
        And I add "par_authority_animal@example.com" to the inputfield "#edit-email"
        When I click on the button "#edit-next"
        Then the element "#edit-authority-contacts" contains the text "Animal"
        Then the element "#edit-authority-contacts" contains the text "the Muppet"
        And the element "#edit-authority-contacts" contains the text "par_authority_animal@example.com"
        And the element "#edit-authority-contacts" contains the text "91723456789"
        And the element "#edit-authority-contacts" contains the text "9777777777"
        When I click on the button "html.js body.js-enabled main#content div div#block-par-theme-content form#par-flow-transition-partnership-details-overview.par-flow-transition-partnership-details-overview div fieldset#edit-authority-contacts.js-form-item.form-item.js-form-wrapper.form-wrapper.inline div fieldset#edit-authority-alternative-contacts.js-form-item.form-item.js-form-wrapper.form-wrapper.inline em.placeholder a.flow-link"
        And I add "Miss" to the inputfield "#edit-first-name"
        And I add "Piggy" to the inputfield "#edit-last-name"
        And I add "par_authority_piggy@example.com" to the inputfield "#edit-email"
        And I add "917234567899" to the inputfield "#edit-work-phone"
        And I add "97777777779" to the inputfield "#edit-mobile-phone"
        When I click on the button "#edit-next"
        Then the element "#edit-authority-alternative-contacts" contains the text "Miss"
        Then the element "#edit-authority-alternative-contacts" contains the text "Piggy"
        And the element "#edit-authority-alternative-contacts" contains the text "par_authority_piggy@example.com"
        And the element "#edit-authority-alternative-contacts" contains the text "917234567899"
        And the element "#edit-authority-alternative-contacts" contains the text "97777777779"
        When I click on the button "html.js body.js-enabled main#content div div#block-par-theme-content form#par-flow-transition-partnership-details-overview.par-flow-transition-partnership-details-overview div fieldset#edit-organisation-contacts.js-form-item.form-item.js-form-wrapper.form-wrapper.inline em.placeholder a.flow-link"
        And I add "Fozzie" to the inputfield "#edit-first-name"
        And I add "Bear" to the inputfield "#edit-last-name"
        And I add "91723456789" to the inputfield "#edit-work-phone"
        And I add "9777777777" to the inputfield "#edit-mobile-phone"
        And I add "par_business_fozzie@example.com" to the inputfield "#edit-email"
        And I click on the button "#edit-next"
        Then the element "#edit-organisation-contacts" contains the text "Fozzie"
        Then the element "#edit-organisation-contacts" contains the text "Bear"
        And the element "#edit-organisation-contacts" contains the text "par_business_fozzie@example.com"
        And the element "#edit-organisation-contacts" contains the text "91723456789"
        And the element "#edit-organisation-contacts" contains the text "9777777777"
        When I click on the button "html.js body.js-enabled main#content div div#block-par-theme-content form#par-flow-transition-partnership-details-overview.par-flow-transition-partnership-details-overview div fieldset#edit-organisation-contacts.js-form-item.form-item.js-form-wrapper.form-wrapper.inline div fieldset#edit-business-alternative-contacts--2.js-form-item.form-item.js-form-wrapper.form-wrapper.inline em.placeholder a.flow-link"
        And I add "917234567899" to the inputfield "#edit-work-phone"
        And I add "97777777779" to the inputfield "#edit-mobile-phone"
        And I add "Pepe" to the inputfield "#edit-first-name"
        And I add "the King Prawn" to the inputfield "#edit-last-name"
        And I add "par_business_pepe@example.com" to the inputfield "#edit-email"
        When I click on the button "#edit-next"
        Then the element "#edit-authority-alternative-contacts" contains the text "par_business_pepe@example.com"
        And the element "#edit-authority-alternative-contacts" contains the text "Pepe"
        And the element "#edit-authority-alternative-contacts" contains the text "the King Prawn"
        And the element "#edit-authority-alternative-contacts" contains the text "917234567899"
        And the element "#edit-authority-alternative-contacts" contains the text "97777777779"
        And I click on the checkbox "#edit-confirmation"
        And I click on the button "#edit-next"
        Then the element "#block-par-theme-content" contains the text "confirmed_authority"
        When I click on the link "Go back to your partnerships"
        Then the element "h1" contains the text "List of Partnerships for a Primary Authority"
        And I click on the link "Log out"
