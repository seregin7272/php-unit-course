<?php

use App\Controllers\CategoryController;
use App\Controllers\HomeController;

$app->get('/', HomeController::class . ':home');
$app->get('/delete-category/{id}', CategoryController::class . ':remove');
$app->get('/show-category/{id}', CategoryController::class . ':show');
$app->get('/edit-category/{id}', CategoryController::class . ':edit');
$app->post('/add-category', CategoryController::class . ':save');