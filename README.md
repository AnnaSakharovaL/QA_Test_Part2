# QA_Test_Part2

1. Для успешного запуска тестов:
- должен быть установлен и запущен Selenium Server. (установить можно, выполнив команду composer global require --dev se/selenium-server-standalone) - тогда запускать сервер можно в консоли по команде selenium-server-standalone
Примечание: если запуск тестов будет происходить на ОС Windows, возможно потребуется подправить файл:
C:\Users\<Пользователь>\AppData\Roaming\Composer\vendor\bin\selenium-server-standalone.bat:
 а) заменить SET BIN_TARGET=%~dp0/../se/selenium-server-standalone/bin/selenium-server-standalone
на 
SET BIN_TARGET=%~dp0/../se/selenium-server-standalone/bin/selenium-server-standalone.jar
 б)  заменить sh "%BIN_TARGET%" %* на java -jar "%BIN_TARGET%" %*
- должны быть установлены PHP 7.3 и Composer версии 1.9.1

2. Также нужно в переменной окружения Path указать путь к файлу chromedriver. Скачать можно отсюда: https://chromedriver.chromium.org/downloads

3. Для установки всех зависимостей необходимо выполнить команду composer install в корне проекта

4. Для запуска тестов последовательно следует выполнить команду vendor\bin\codecept run acceptance

5. Для запуска тестов параллельно следует выполнить команду vendor\bin\robo parallel:all
