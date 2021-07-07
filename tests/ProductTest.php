<?php

class ProductTest extends \PHPUnit\Framework\TestCase
{

    public function testProduct(): void
    {
        $session = new class implements SessionInterface {

            public function open()
            {
                // TODO: Implement open() method.
            }

            public function close()
            {
                // TODO: Implement close() method.
            }

            public function write($product)
            {
                echo 'mock session write ' . $product;
            }
        };

        $product = new Product($session);
        $product->setAddLoggerCallable(
            function () {
                echo 'not real logger';
            }
        );
        self::assertSame('product 1', $product->fetchProductById(1));
    }

    public function testProductCanImages(): void
    {
        self::markTestIncomplete(
            'Добавление изображенией пока нет'
        );

        if(!\extension_loaded('xdebug')){
            self::markTestSkipped(
                'extension xdebug is not avialable'
            );
        }

        self::assertTrue(true);

    }

}