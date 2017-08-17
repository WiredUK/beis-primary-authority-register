/**
 * Check if the given elements text is the same as the given text
 * @param  {Function} done          Function to execute when finished
 */

module.exports = (username, done) => {
    /**
     * The command to perform on the browser object (addValue or setValue)
     * @type {String}
     */
    browser.setValue('#edit-name', username);
    browser.setValue('#edit-pass', 'TestPassword');
    browser.click('#edit-submit');
    done();
};