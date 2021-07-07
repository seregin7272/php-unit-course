<?php

class BMICalculatorTest extends \PHPUnit\Framework\TestCase
{
    public function testUnderWeightText(): void
    {
        $bmi = new BMICalculator();
        $bmi->BMI = 17;
        $result = $bmi->getTextResult();
        $expected = 'Недостаточная масса';

        self::assertSame($expected, $result);
    }

    public function testNormalWeightText(): void
    {
        $expected = 'Нормальная масса';
        $bmi = new BMICalculator();
        $bmi->BMI = 18;
        $result = $bmi->getTextResult();

        self::assertSame($expected, $result);

        $bmi->BMI = 25;
        $result = $bmi->getTextResult();

        self::assertSame($expected, $result);
    }

    public function testOverWeightText(): void
    {
        $bmi = new BMICalculator();
        $bmi->BMI = 26;
        $result = $bmi->getTextResult();
        $expected = 'Избыточная масса';

        self::assertSame($expected, $result);
    }

    public function testCorrectValueCalc(): void
    {
        $expected = 26.6;
        $bmi = new BMICalculator();
        $bmi->mass = 77;
        $bmi->height = 1.7;
        $result = $bmi->calculate();
        self::assertSame($expected, $result);
    }

    public function testHomePage(): void
    {
        self::assertEquals(BASE_URL, 'http://php-unit-course.loc');
    }
}