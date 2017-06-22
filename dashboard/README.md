# Dashboard

The dashboard we're using for development purposes uses Smashing, and integrates with Github, Travis, Production metrics amongst other useful real time stats.

## Pre-requisites include
* Ruby ^3.0
* Ruby gems smashing and bundler

## Install
To configure the production endpoint set the environment var PROD_ENDPOINT before running `export PROD_ENDPOINT="http://example.com"`

    cd dashboard
    bundle
    smashing start
    
## Running
Smashing starts the thin webserver so that the smashing dashboard will then be accessible at `localhost:3030/devops`

Check out http://smashing.github.io/ for more information.