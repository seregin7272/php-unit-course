<?php
declare(strict_types=1);

class WaitingTest extends \PHPUnit\Extensions\Selenium2TestCase
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

    public function testExplicitWait(): void
    {
        $driver = $this;
        $this->url('');
        $this->waitUntil(
            function () use ($driver) {
                $item = $driver->byId('first-name');
                if ($item->value() === 'Adam') {
                    return true;
                }

                return null;
            },
            4000
        );

        $this->assertSame('Adam', $this->byId('first-name')->value());

    }
}