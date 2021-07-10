<?php
declare(strict_types=1);

class CookieTest extends PHPUnit\Extensions\Selenium2TestCase
{
    protected function setUp(): void
    {
        $this->setHost('selenium');
        $this->setBrowserUrl('http://php-unit-course.loc/test-form-page.html');
        $this->setBrowser('chrome');
        $this->setDesiredCapabilities(
            ['chromeOptions' => ['w3c' => false]]
        ); // phpunit-selenium does not support W3C mode yet
    }

    public function testLogin(): void
    {
        $this->url('');
        $session = $this->prepareSession();
        $session->cookie()->add('user', 'logged-in')->set();

        $loggedCookie = $session->cookie()->get('user');

        self::assertSame('logged-in', $loggedCookie);
    }
}