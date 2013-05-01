PHP Selenium Demo
=================

Dependencies and Setup
----------------------

### PHP

You must have at least PHP 5.3.3+ installed on your system.

### Composer

If you don't have [Composer][] yet, download it following the instructions on
http://getcomposer.org/ or just run the following commands:

    curl -s https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer

Once Composer is installed, run the following command to install the remaining
dependencies:

    composer install

### Selenium

Download the latest version of the [selenium-server-standalone][seleinum-download-list].
If you also want to run selenium tests using Google Chrome, you will need to download
the [Chrome Driver][selenium-chrome-driver].

Starting Selenium
-----------------

### Starting a Hub

You will need to start a hub in order to work with Selenium. To start the hub,
run the following command:

    java -jar selenium-server-standalone-2.32.0.jar -role hub

### Starting a Remote

You will also need to connect a remote to the hub. To add a remote to the hub,
run the following command:

    java -jar selenium-server-standalone-2.32.0.jar -role webdriver -Dwebdriver.chrome.driver="/location/to/chromedriver"

### Verifying Hub and Remote's Status

You can verify that the remote connected to the hub and check the remote's status
by visiting [http://localhost:4444/grid/console][selenium-grid-console] in your browser.

Demo
----

You can view the demo code by going into the /Tests directory and opening up the
php files inside.

Before running the demo, copy phpunit.xml.dist to phpunit.xml and modify the constants
SCAN_USERNAME and SCAN_PASSWORD to be actual values that can be used to log into
http://scan.me.

After making these changes, you can run the demo by typing the following
at the root of the project:

    ./bin/phpunit

[composer]: http://getcomposer.org/
[seleinum-download-list]: https://code.google.com/p/selenium/downloads/list
[selenium-chrome-driver]: https://code.google.com/p/chromedriver/downloads/list
[selenium-grid-console]: http://localhost:4444/grid/console
