<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;

class HomeController extends BaseController
{
    public function home($request, $response, $args)
    {
        return $this->container->view->render($response, 'view.phtml');
    }
}