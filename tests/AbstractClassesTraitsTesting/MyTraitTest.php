<?php
declare(strict_types=1);

namespace AbstractClassesTraitsTesting;

use forTestingAbstractClassesAndTraits\MyTrait;

class MyTraitTest extends \PHPUnit\Framework\TestCase
{
    public function testMethodTrait()
    {
        $mock = $this->getMockBuilder(MyTrait::class)->getMockForTrait();

        self::assertEquals(20,$mock->traitMethod(10));
    }

}