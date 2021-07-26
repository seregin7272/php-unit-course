<?php

namespace App\Tests\Integration;

use App\User;
use PHPUnit\Framework\TestCase;

/**
 * Здесь протестируйте интеграцию классов User и Database.
 * Этот тест должен четко указать, что не так с этим приложением.
 * Утверждаем, что, например, 'Adam' (обратите внимание, что первая буква в верхнем регистре) равен
 * результату функции getUser из класса User.
 *
 * Вы не должны создавать экземпляр класса базы данных - он расширяется классом User.
 *
 * Class IntegrationTest
 * @package App\Tests\Integration
 */
class IntegrationTest extends TestCase
{

    public function testCanGetCorrectUserName(): void
    {
        $user = new User();

        $name = $user->getUser(3);
        self::assertSame('John', $name);
    }

}   