<?php

class UserTest extends \PHPUnit\Framework\TestCase
{

    public function testCorrectName(): void
    {
        $user = new User('donald', 'Trump');
        $phpUnit = $this;

        $closure = function () use ($phpUnit) {
            $phpUnit->assertSame('Donald', $this->name);
        };

        $binding = $closure->bindTo($user, get_class($user));

        $binding();
    }

    public function testCorrectLastName(): void
    {
        $user = new class('donald', 'Trump') extends User {
            public function getLastName(): string
            {
                return $this->lastName;
            }
        };

        self::assertSame('Trump', $user->getLastName());
    }

    public function testCorrectFullName(): void
    {
        $mokeDb = new class extends DataBase
        {
            public function getUser(): void
            {
                echo 'moke db';
            }
        };

        $user = new User('donald', 'Trump');

        $closure = function () use ($mokeDb) {
            $this->db = $mokeDb;
        };

        $binding = $closure->bindTo($user, get_class($user));

        $binding();

        self::assertSame('Donald Trump', $user->getFullName());
    }

    public function testCorrectPasswordHash(): void
    {
        $user = new class('donald', 'Trump') extends User {
            public function getUserPasswordHash(): string
            {
                return $this->passwordHash();
            }
        };

        self::assertSame('password hash', $user->getUserPasswordHash());
    }

    public function testCorrectPasswordHash2(): void
    {
        $phpUnit = $this;
        $user = new User('donald', 'Trump');
        $closure = function () use ($phpUnit) {
           $phpUnit->assertSame('password hash', $this->passwordHash());
        };

        $binding = $closure->bindTo($user, get_class($user));

        $binding();
    }

    public function testSomeOperation(): void
    {
        $user = new User('donald', 'Trump');
        $result = $user->someOperation([1, 2, 3]);
        self::assertEquals('ok!', $result);

        $result = $user->someOperation([0]);
        self::assertEquals('error', $result);

        $result = $user->someOperation([1]);
        self::assertEquals('ok!', $result);

        $result = $user->someOperation([]);
        self::assertEquals('error', $result);
    }

}