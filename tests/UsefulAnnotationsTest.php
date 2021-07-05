<?php

class UsefulAnnotationsTest extends \PHPUnit\Framework\TestCase
{
    private $value = 0;

    /**
     * @before
     */
    public function runBeforeEachMethod()
    {
        $this->value++;
    }

    /**
     * @beforeClass
     */
    public static function runBeforeClass()
    {

    }

    public function testAnnotations1()
    {
        $this->value++;
        $expected = 2;
        $result = $this->value;
        self::assertEquals($expected, $result);
    }

    public function testAnnotations2(): int
    {
        $this->value++;
        $expected = 2;
        $result = $this->value;
        self::assertEquals($expected, $result);
        return $this->value;
    }

    /**
     * @depends testAnnotations2
     */
    public function testDepends1($value)
    {
        $value++;
        self::assertEquals(3, $value);
    }
    /**
     * @dataProvider emailsData
     */
    public function testValidEmail($email)
    {
        self::assertRegExp('/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/', $email);
    }


    public function emailsData(): array
    {
        return [
            ['seregin7227@mail.ru'],
            ['qwqe@ttt.ty'],
            ['rt@rrrr.ppii']
        ];
    }
}