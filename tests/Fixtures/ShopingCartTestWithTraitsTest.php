<?php

class ShopingCartTestWithTraitsTest extends \PHPUnit\Framework\TestCase
{
    use DatabaseTrait;
    use ShoppingCartFixtureTrait;

    public function testCorrectNumberOfItems()
    {
        $expected = 1;
        $this->cart->addItem('one');
        $result = $this->cart->amount;
        $this->assertEquals($expected, $result);
    }

    public function testCorrectProductName()
    {
        $this->cart->addItem('Apple');
        $this->assertContains('Apple', $this->cart->cartItems);
    }
}