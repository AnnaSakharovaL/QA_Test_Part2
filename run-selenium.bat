@ECHO OFF

IF [%1] == [] (
    ECHO Specify path to chrome drive in 1st parameter of script
    EXIT /B 1
)

java -Dwebdriver.chrome.driver="%1" -jar vendor\se\selenium-server-standalone\bin\selenium-server-standalone.jar
