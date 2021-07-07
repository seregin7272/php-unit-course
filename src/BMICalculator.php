<?php
declare(strict_types=1);

class BMICalculator
{
    public float $BMI;

    public float $mass;

    public float $height;

    public function calculate(): float
    {
        return round($this->mass / ($this->height ** 2), 1);
    }

    public function getTextResult(): string
    {
        if ($this->BMI < 18) {
            $result = 'Недостаточная масса';
        } elseif ($this->BMI >= 18 && $this->BMI <= 25) {
            $result = 'Нормальная масса';
        } else {
            $result = 'Избыточная масса';
        }

        return $result;
    }

}