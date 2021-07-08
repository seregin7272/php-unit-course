<?php
declare(strict_types=1);

namespace stubMockTesting;

use forStubMockTesting\Logger;

class UserTest extends \PHPUnit\Framework\TestCase
{

    public function testInvalidEmailCreateUser(): void
    {
        $loggerStub = $this->createMock(Logger::class);

        $loggerStub->expects($this->once())
                   ->method('log')
                   ->with(
                       $this->equalTo('error'),
                       $this->anything()
                   );

        $userStub = $this->getMockBuilder(\forStubMockTesting\User::class)
                         ->onlyMethods(['save'])
                         ->setConstructorArgs([$loggerStub])
                         ->getMock();

        $userStub->method('save')->willReturn(true);

        $userStub->createUser('Ivan', 'ivan@', 12);
    }

    public function testSuccessSave(): void
    {
        $loggerStub = $this->createMock(Logger::class);

        $loggerStub->expects($this->exactly(2))
                   ->method('log')
                   ->withConsecutive(
                       [$this->equalTo('notice'), $this->stringContains('less than 18')],
                       [$this->equalTo('success'), $this->stringContains('was saved')],
                   );

        $userStub = $this->getMockBuilder(\forStubMockTesting\User::class)
                         ->onlyMethods(['save'])
                         ->setConstructorArgs([$loggerStub])
                         ->getMock();

        $userStub->method('save')->willReturn(true);

        $userStub->createUser('Ivan', 'ivan@ph.gr', 12);
    }
}