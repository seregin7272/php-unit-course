<?php

class DataBase
{
    /**
     * @codeCoverageIgnore
     */
    public function getUser(): void
    {
        echo 'real  db touched';
    }
}

class User
{
    private string $name;

    protected string $lastName;

    private $db;

    public function __construct($name, $lastName)
    {
        $this->name = ucfirst($name);
        $this->lastName = ucfirst($lastName);
        $this->db = new DataBase();
    }

    public function getFullName(): string
    {
        $this->db->getUser();

        return $this->name . ' ' . $this->lastName;
    }

    protected function passwordHash(): string
    {
        return 'password hash';
    }

    public function someOperation($array): string
    {
        $count = count($array);
        if($count === 0) {
            return 'error';
        }
        elseif ($count === 1){
            if($array[0] === 0) {
                return 'error';
            }
            else {
                return 'ok!';
            }

        }else{
            return 'ok!';
        }
    }

}