<?php

class Logger
{
    public static function log($data): void
    {
        echo 'real write log ' . $data;
    }
}