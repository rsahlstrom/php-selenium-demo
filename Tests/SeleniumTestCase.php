<?php

namespace Tests;

/**
 * Selenium test case
 *
 * This class uses these config constants:
 * - HUB (optional)
 */
abstract class SeleniumTestCase extends \PHPUnit_Framework_TestCase {

    /**
     * Default Selenium grid to connect to if no hub set
     *
     * @var string
     */
    CONST DEFAULT_HUB = 'localhost:4444';

    /**
     * Selenium hub actually used to connect
     * @var string|null
     */
    protected $hub = null;

    /**
     * Driver for selenium
     *
     * @var WebDriver
     */
    protected $driver;

    /**
     * List of browsers that Selenium will use to run its tests
     *
     * @var array
     */
    protected $browsers = array('firefox', 'chrome');

    /**
     * Sets up the test case by starting the driver
     *
     * @return void
     */
    protected function setUp() {
        parent::setUp();
        $this->driver = $this->initDriver();
    }

    /**
     * Creates a WebDriver instance to run the selenium tests
     *
     * @param string $browser
     * @param array $capabilities
     *
     * @return WebDriver
     */
    protected function initDriver($browser = null, $capabilities = array()) {
        if ($browser === null) {
            $browser = $this->getRandomBrowser();
        }
        $hubAddress = $this->getHubAddress();
        return \WebDriver_Driver::InitAtHost($hubAddress['url'], $hubAddress['port'], $browser, $capabilities);
    }

    /**
     * Returns a random browser
     *
     * @return string
     */
    protected function getRandomBrowser() {
        $browser_index = rand(0, count($this->browsers) - 1);
        return $this->browsers[$browser_index];
    }

    /**
     * Route all unknown function calls to the driver
     *
     * @param string $name
     * @param array $arguments
     *
     * @throws Exception
     */
    public function __call($name, $arguments) {
        if ($this->driver === null) {
            throw new \Exception("Tried to call nonexistent method $name with arguments (No Driver):\n" . print_r($arguments, true));
        }

        if (method_exists($this->driver, $name)) {
            return call_user_func_array(array($this->driver, $name), $arguments);
        } else {
            throw new \Exception("Tried to call nonexistent method $name with arguments:\n" . print_r($arguments, true));
        }
    }

    /**
     * Shuts down the driver once it has completed
     *
     * @return void
     */
    public function tearDown() {
        if ($this->driver) {
            $this->driver->quit();
        }
        parent::tearDown();
    }

    /**
     * Returns the hub as a url and a port
     *
     * @return array
     */
    public function getHubAddress() {
        $hub = $this->getHub();
        $parts = explode(':', $hub);
        $address = array(
            'url' => $parts[0],
            'port' => '4444',
        );

        if (isset($parts[1])) {
            $address['port'] = $parts[1];
        }

        return $address;
    }

    /**
     * Returns the hub from the config
     *
     * @return string
     */
    public function getHub() {
        if ($this->hub === null) {
            $this->setHub(self::DEFAULT_HUB);
            if (defined('HUB')) {
                $this->setHub(HUB);
            }
        }
        return $this->hub;
    }

    /**
     * Set the Selenium Hub Address
     *
     * @param $hub
     */
    public function setHub($hub) {
        $this->hub = $hub;
    }

}
