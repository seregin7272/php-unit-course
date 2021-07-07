<?php

class Product
{

    private SessionInterface $session;
    protected  $addLoggerCallable = [Logger::class, 'log'];


    public function setAddLoggerCallable(callable $addLoggerCallable): void
    {
        $this->addLoggerCallable = $addLoggerCallable;
    }

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function fetchProductById($id): string
    {
        // call db
        $product = 'product ' . $id;
        $this->session->write($product);
        //Logger::log($product);
        call_user_func($this->addLoggerCallable, $product);

        return $product;
    }


}