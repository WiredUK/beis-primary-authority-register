const config = require('./wdio.conf.js').config;

config.capabilities = [{
    browserName: 'chrome',
    chromeOptions: {
        binary: '/usr/bin/google-chrome',
        args: ['headless', 'no-sandbox', 'disable-gpu'],
    },
}];
config.screenshotPath = './errorShots/';
config.services = ['selenium-standalone'];
config.baseUrl = 'http://127.0.0.1:80';
config.tags = '@setup';
config.cucumberOpts.failFast = true;
exports.config = config;
