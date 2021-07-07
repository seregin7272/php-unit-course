<?php
declare(strict_types=1);

class CalculatorTest extends \PHPUnit\Framework\TestCase
{
    private Calculator $calc;

    protected function setUp(): void
    {
        $this->calc = new Calculator();
    }

    public function testCanAdd(): void
    {
        $result = $this->calc->add(4, 6);
        self::assertEquals(10, $result);
    }

    public function testCanSubtract(): void
    {
        $result = $this->calc->subtract(6, 4);
        self::assertEquals(2, $result);
    }

    public function testCanMultiply(): void
    {
        $result = $this->calc->multiply(6, 4);
        self::assertEquals(24, $result);
    }

    public function testCanDivide(): void
    {
        $result = $this->calc->divide(6, 3);
        self::assertEquals(2, $result);
    }

}