<?php

class Session implements SessionInterface
{

    public function open()
    {
        echo 'real session open';
    }

    public function close()
    {
        echo 'real session close';
    }

    public function write($product)
    {
        echo 'real session write ' . $product;
    }
}