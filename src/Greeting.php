<?php
namespace App;

class Greeting {

    public $current_hour;

    public function __construct($current_hour)
    {
        $this->current_hour = $current_hour;
    }

    public function getGreeting()
    {
        if($this->current_hour  >= 5 && $this->current_hour < 12 ) return 'Good morning';
        elseif($this->current_hour  >= 12 && $this->current_hour < 17 ) return 'Good afternoon';
        elseif($this->current_hour  >= 17 && $this->current_hour <= 23 ) return 'Good evening';
        else return 'Good night';
    }
}
    