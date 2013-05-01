<?php

namespace Tests\Scan;

use Tests\SeleniumTestCase;

class LoginTest extends SeleniumTestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->driver->set_implicit_wait(5000);
    }

    public function testLoginSuccess()
    {
        $this->load('http://scan.me');
        $signIn = $this->get_element('link=Sign In');
        $signIn->click();

        $usernameField = $this->get_element('css=#loginIdentifier');
        $usernameField->send_keys(SCAN_USERNAME);

        $passwordField = $this->get_element('css=#loginPassword');
        $passwordField->send_keys(SCAN_PASSWORD);

        $this->get_element('css=#login')->submit();

        $this->assert_element_present('link=Log Out');
    }

    public function testLoginFails()
    {
        $this->load('http://scan.me');
        $signIn = $this->get_element('link=Sign In');
        $signIn->click();

        $usernameField = $this->get_element('css=#loginIdentifier');
        $usernameField->send_keys('badusername');

        $passwordField = $this->get_element('css=#loginPassword');
        $passwordField->send_keys('badpassword');

        $this->get_element('css=#login')->submit();

        $this->assert_element_present('css=#login .formFailureNotice');
        $this->get_element('css=#login .formFailureNotice')->assert_text('Bad login');
    }
}
