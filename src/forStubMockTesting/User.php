<?php
declare(strict_types=1);

namespace forStubMockTesting;

class User
{
    private Logger $logger;

    private $name;

    private $email;

    private $age;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function createUser($name, $email, $age): bool
    {
        $this->name = $name;
        $this->email = $email;
        $this->age = $age;

        if (!$this->validate()) {
            return false;
        }

        if ($this->age < 18) {
            $this->logger->log('notice', 'Age less than 18');
        }

        $this->logger->log('success', 'User was saved');
        return $this->save();
    }

    public function validate(): bool
    {

        if (!is_string($this->name)) {
            $this->logger->log('error', 'Invalid name');

            return false;
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->logger->log('error', 'Invalid email');

            return false;
        }

        if (!is_int($this->age)) {
            $this->logger->log('error', 'Invalid age');

            return false;
        }

        return true;
    }

    public function save()
    {
        echo 'User was saved in database - real operation!';

        return true;
    }
}