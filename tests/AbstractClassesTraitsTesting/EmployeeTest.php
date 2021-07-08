<?php
declare(strict_types=1);

namespace AbstractClassesTraitsTesting;

use forTestingAbstractClassesAndTraits\PersonAbstract;

class EmployeeTest extends \PHPUnit\Framework\TestCase
{
    public function testFullName(): void
    {

        $mock = $this->getMockBuilder(PersonAbstract::class)
                     ->setConstructorArgs(['John', 'Doe'])
                     ->getMockForAbstractClass();

        $mock
            ->method('getSalary')
            ->willReturn(6000);

        $this->assertSame('John Doe earns 6000 per month', $mock->showFullNameAndSalary());
    }
}