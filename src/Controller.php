<?php
namespace App;

class Controller {

    protected $user;
    protected $greeting;
    public $css_class;

    public function __construct(User $user, Greeting $greeting)
    {
        $this->user = $user->getUser(1);
        $this->greeting = $greeting->getGreeting();

        if(preg_match('/^[A-Z]{1}[a-z]+$/', $this->user)) $this->css_class = 'blue';
    }

    public function getResponse()
    {
        return $this->greeting . ' ' . $this->user;
    }
}