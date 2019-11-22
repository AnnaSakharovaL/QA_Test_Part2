# QA_Test_Part2

1. Для успешного запуска тестов должен быть установлен и запущен Selenium Server. (установить можно, выполнив команду composer global require --dev se/selenium-server-standalone) - тогда запускать сервер можно в консоли по команде selenium-server-standalone
Примечание: если запуск тестов будет происходить на ОС Windows, возможно нужно будет подправить файл:
C:\Users\<Пользователь>\AppData\Roaming\Composer\vendor\bin selenium-server-standalone:
- в последней строке должно быть указано: java -jar "%BIN_TARGET%" %* вместо sh "%BIN_TARGET%" %*
2. Также нужно в переменной окружения Path указать путь к файлу chromedriver

2. Для запуска тестов параллельно (при желании) нужно установить Robo tool, выполнив команду composer require "codeception/robo-paracept:dev-master" --dev в корне проекта (это делается перед установкой Codeception, т.к. по словам оф. документации иначе работать не будет)
3. Далее необходимо установить Codeception, выполнив команду composer require "codeception/codeception" --dev
4. Запустить тесты можно, выполнив команду vendor/bin/codecept run acceptance
