<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends BaseController
{
    public function remove($request, $response, $args)
    {
        $categoryId = $args['id'];

        $category = Category::find($categoryId);
        $_SESSION['messages']['categoryDeleted'] = $category->delete();
        return $response->withRedirect('/', 301);
        //return $this->container->view->render($response, 'view.phtml', ['categoryDeleted' => true]);
    }

    public function show($request, $response, $args)
    {
        $category_id = explode(',', $args['id']);
        $category = Category::find((int)$category_id[0]);

        return $this->container->view->render($response, 'view.phtml', ['category' => $category]);
    }

    public function edit($request, $response, $args)
    {
        $category_id = explode(',', $args['id']);
        $category = Category::find((int)$category_id[0]);

        return $this->container->view->render($response, 'view.phtml', ['editCategory' => $category]);
    }

    public function save($request, $response, $args)
    {
        $input = $request->getParsedBody();
        $_SESSION['messages']['addCategory'] = false;
        if (!empty($input['name']) && !empty($input['description'])) {

            $category = isset($input['category_id']) ? Category::find((int)$input['category_id']) : new Category();

            $category->name = $input['name'];
            $category->description = $input['description'];
            $category->parent_id = $input['categories_list'] > 0 ? (int)$input['categories_list'] : null;
            $_SESSION['messages']['addCategory'] = $category->save();
        }

        return $response->withRedirect('/', 301);

        //return $this->container->view->render($response, 'view.phtml', compact('addCategory'));
    }

}