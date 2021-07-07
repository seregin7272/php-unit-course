<?php

class ShopingCart
{

    public array $cartItems = [];

    public int $amount = 0;

    public function addItem($item): void
    {
        $this->cartItems[] = $item;
        $this->amount++;
    }

}