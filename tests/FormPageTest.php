<?php
declare(strict_types=1);

class FormPageTest extends \PHPUnit\Extensions\Selenium2TestCase
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

    public function testFormPage()
    {
        $this->url('');

        $select = $this->byId('option-element');
        $this->select($select)->selectOptionByLabel('Option 2');
        // $this->select($select)->selectOptionByValue('option-2');
        // $this->select($select)->clearSelectedOptions();

        $inputUserName = $this->byName('some_input_name');
        $inputUserName->value('Ivan');
        // $inputUserName->clear();

        $radios = $this->elements($this->using('css selector')->value('input[type="radio"]'));
        $radios[0]->click();

        $this->byCssSelector('input[type="checkbox"]')->click();

        $this->byTag('textarea')->value('Some text');

        $this->clickOnElement('submit-button');
        // $this->byId('submit-button')->submit();

        self::assertStringContainsString('The form was sent!', $this->source());

    }

}