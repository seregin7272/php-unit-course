<?php
declare(strict_types=1);

namespace forTestingAbstractClassesAndTraits;

class Employee extends PersonAbstract
{

    public function getSalary(): int
    {
        return 50 * 100; // $ * h
    }

}