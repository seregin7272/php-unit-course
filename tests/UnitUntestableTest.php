<?php
declare(strict_types=1);

use dzMock\DataSource;
use dzMock\UnitUntestable;

class UnitUntestableTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider getDataQoute
     */
    public function testRandomQoute($random, $textContains): void
    {
        $stub = $this->createMock(DataSource::class);
        $stub->method('fetchQuote')->willReturn('fake');
        $result = (new UnitUntestable($stub))->setRandom($random)->getRandomQoute();

        self:: assertStringContainsString($textContains, $result);
    }

    public function getDataQoute(): array
    {
        return [
            'zero'             => [0, 'one the famous physicist'],
            'one'              => [1, 'head of the Catholic Church and sovereign of the Vatican City'],
            'two'              => [2, 'the co-founder of Microsoft Corporation'],
            'greater  than 18' => [3, 'the co-founder of Microsoft Corporation'],
        ];
    }

}