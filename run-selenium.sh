#!/bin/bash

CHROME_DRIVER=${1?'Specify path to chrome drive in 1st parameter of script'}

java -Dwebdriver.chrome.driver="$CHROME_DRIVER" -jar vendor\se\selenium-server-standalone\bin\selenium-server-standalone.jar
