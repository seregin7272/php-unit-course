<?php

namespace  App\Tests\Acceptance;

class AcceptanceTest extends \PHPUnit\Extensions\Selenium2TestCase
{
    protected function setUp(): void
    {
        $this->setHost('selenium');
        $this->setBrowserUrl('http://php-unit-course.loc');
        $this->setBrowser('chrome');
        $this->setDesiredCapabilities(
            ['chromeOptions' => ['w3c' => false]]
        ); // phpunit-selenium does not support W3C mode yet
    }

    /**
     * DZ: этот тест завершится неудачно, но он не скажет вам, что не так, только интеграционный тест ясно скажет вам, что не так с приложением.
     * Если вы исправите, это утверждение должно пройти.
     */
    public function testContent()
    {
        $this->url('');
        $elem = $this->byClassName('blue');
        $this->assertStringContainsString('This is an awesome App!', $this->source());
        $this->assertRegExp('/^Good (morning|afternoon|evening|nigth) [A-Z]{1}[a-z]+$/', $elem->text());
    }
}