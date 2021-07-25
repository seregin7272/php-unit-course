<?php
declare(strict_types=1);
session_start();
use App\Models\Category;

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal(); // allow static methods
$capsule->bootEloquent(); // setup the Eloquent ORM

$container->view->addAttribute('categories', \App\Services\CategoriesFactory::createMainMenu());
$container->view->addAttribute('selectCategoryList', \App\Services\CategoriesFactory::createSelectList());
$container->view->addAttribute('messages', $_SESSION['messages']?? []);
