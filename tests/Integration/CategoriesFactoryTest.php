<?php
declare(strict_types=1);

namespace App\Tests\Integration;

use App\Models\Category;
use App\Services\CategoriesFactory;

class CategoriesFactoryTest extends \PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass(): void
    {
        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection(
            [
                'driver'    => 'sqlite',
                'host'      => 'localhost',
                'database'  => '/var/www/php-unit-course/data/db.sqlite',
                'username'  => 'user',
                'password'  => 'password',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ]
        );
        $capsule->setAsGlobal(); // allow static methods
        $capsule->bootEloquent(); // setup the Eloquent ORM
    }

    public function testCanProduceStringBasedOnArray(): void
    {
        $this->assertIsString(CategoriesFactory::createMainMenu());
    }

    public function testProduceArrayBasedOnArray(): void
    {
        self::assertIsArray(CategoriesFactory::createSelectList());
    }
}