<?php

class ExceptionErrorTest extends \PHPUnit\Framework\TestCase
{
    public function testErrorCanBeExcepted()
    {
        $this->expectError();
        $this->expectErrorMessage('foo');

        \trigger_error('foo', \E_USER_ERROR);
    }
}