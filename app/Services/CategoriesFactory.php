<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Category;

class CategoriesFactory
{
    public static function createMainMenu(): string
    {
        $categoriesList = Category::all()->toArray();
        $html = new HtmlList();
        $convertData = $html->convert($categoriesList);
        return $html->makeUlList($convertData);
    }

    public static function createSelectList(): array
    {
        $categoriesList = Category::all()->toArray();
        $html = new HtmlList();
        $convertData = $html->convert($categoriesList);
        return $html->makeSelectList($convertData);
    }
}