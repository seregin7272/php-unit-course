<?php

class HtmlPageTest extends PHPUnit\Extensions\Selenium2TestCase
{
    public function setUp(): void
    {
        $this->setHost('selenium');
        $this->setBrowserUrl('http://php-unit-course.loc/test-html-page.html');
        $this->setBrowser('chrome');
        $this->setDesiredCapabilities(
            ['chromeOptions' => ['w3c' => false]]
        ); // phpunit-selenium does not support W3C mode yet
    }

    public function testGettingElements(): void
    {
        $this->url('');

        $h1 = $this->byCssSelector('header h1'); // p.class  p#id  input[name="myname"]  .alert.alert-danger
        $this->assertSame('HTML', $h1->text());

        $h1 = $this->elements($this->using('css selector')->value('h1'));
        $this->assertCount(16, $h1);
        $this->assertStringContainsString('Headings', $h1[2]->text());

        $field = $this->byId('first-name');
        $this->assertSame('Adam', $field->value()); // $field->name()
        $this->assertSame('Adam', $field->attribute('value'));

        $link = $this->byId('google-link-id'); // $this->byName  $this->byClassName
        $this->assertSame('Google', $link->text());

        $this->clickOnElement('google-link-id');
        $this->back();
        //$this->forward();
        $this->refresh();

        $content = $this->byTag('body')->text();
        $this->assertStringContainsString('Every html element in one place. Just waiting to be styled.', $content);

        $this->assertStringContainsString('At vero eos et accusamus', $this->source());
    }

    public function testClickLink(): void
    {
        $this->url('');
        $link = $this->byId('google-link-id');
        $link->click();

        $this->assertEquals('Google', $this->title());
    }

    public function testTitle(): void
    {
        $this->url('');
        $this->assertEquals('HTML by Adam Morse, mrmrs.cc', $this->title());
    }
}