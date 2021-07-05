<?php

class BMICalculatorTest extends \PHPUnit\Framework\TestCase
{
    public function testUnderWeightText()
    {
        $bmi = new BMICalculator();
        $bmi->BMI = 17;
        $result = $bmi->getTextResult();
        $expected = 'Недостаточная масса';

        self::assertSame($expected, $result);
    }

    public function testNormalWeightText()
    {
        $bmi = new BMICalculator();
        $bmi->BMI = 24;
        $result = $bmi->getTextResult();
        $expected = 'Нормальная масса';

        self::assertSame($expected, $result);
    }

    public function testOverWeightText()
    {
        $bmi = new BMICalculator();
        $bmi->BMI = 26;
        $result = $bmi->getTextResult();
        $expected = 'Избыточная масса';

        self::assertSame($expected, $result);
    }

    public function testCorrectValueCalc()
    {
        $expected = 27.7;
        $bmi = new BMICalculator();
        $bmi->mass = 100;
        $bmi->height = 1.9;
        $result = $bmi->calculate();
        self::assertSame($expected, $result);
    }

    public function testHomePage()
    {
        self::assertEquals(BASE_URL, 'http://php-unit-course.loc');
    }
}