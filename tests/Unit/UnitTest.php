<?php

namespace App\Tests\Unit;

use App\Greeting;
use PHPUnit\Framework\TestCase;

/**
 * Проверяем здесь все четыре случая из класса Greeting
 */
class UnitTest extends TestCase
{

    /**
     * @param $hour
     * @param $excepted
     *
     * @dataProvider greetingsProvider
     */
    public function testGreetings($hour, $excepted): void
    {
        $greeting = new Greeting($hour);
        self::assertEquals($excepted, $greeting->getGreeting());
    }

    public function greetingsProvider(): array
    {
        return [
            [0, 'Good night'],
            [4, 'Good night'],
            [5, 'Good morning'],
            [11, 'Good morning'],
            [12, 'Good afternoon'],
            [16, 'Good afternoon'],
            [17, 'Good evening'],
            [23, 'Good evening'],
            [24, 'Good night'],
        ];
    }

}   