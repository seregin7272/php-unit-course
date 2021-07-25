<?php
declare(strict_types=1);

namespace App\Tests\Integration;

use App\Controllers\CategoryController;
use Slim\Container;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

class CategoryControllerTest extends \PHPUnit\Framework\TestCase
{

    public function testCanSeeEditedCategory(): void
    {
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => 'GET',
                'REQUEST_URI'    => '/show-category/13,Videos',
            ]
        );
        $request = Request::createFromEnvironment($environment);
        $response = new Response();
        $container = new Container();
        $container['my_service'] = function ($c) {
            return 'My service in action, ';
        };

        $container['view'] = new \Slim\Views\PhpRenderer(
            './app/Views/', [
                              'baseUrl' => 'http://php-unit-course.loc',
                          ]
        );

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

        $container->view->addAttribute('categories', \App\Services\CategoriesFactory::createMainMenu());
        $container->view->addAttribute('selectCategoryList', \App\Services\CategoriesFactory::createSelectList());

        $responseController = (new CategoryController($container))->show($request, $response, ['id' => '13,Videos']);

        $this->assertStringContainsString('Description of Videos', (string)$responseController->getBody());

    }

}