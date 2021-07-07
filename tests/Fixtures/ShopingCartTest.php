<?php

class ShopingCartTest extends \PHPUnit\Framework\TestCase
{

    protected static $dbConnection;

    protected $cart;

    protected function setUp(): void
    {
        $this->cart = new ShopingCart();
    }

    protected function tearDown(): void
    {
        unset($this->cart);
    }

    public function testCorrectCartCount(): void
    {
        $this->cart->addItem('one');
        self::assertEquals(1, $this->cart->amount);
    }

    public function testCorrectProductName(): void
    {
        $this->cart->addItem('one');
        self::assertContains('one', $this->cart->cartItems);
    }

    public static function setUpBeforeClass(): void
    {
        if (static::$dbConnection) {
            return;
        }

        static::$dbConnection = new \PDO('sqlite:db_test.db');
    }

    public static function tearDownAfterClass(): void
    {
        if (self::$dbConnection) {
            self::$dbConnection = null;
            unlink('db_test.db');
        }
    }

}