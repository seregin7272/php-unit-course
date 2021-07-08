<?php
declare(strict_types=1);

namespace forStubMockTesting;

class Logger
{
    public function log($message_type, $message): void
    {
        echo 'real Logger executed';
    }
}