<?php
declare(strict_types=1);

namespace App\Services;

class HtmlList extends CategoryTree
{
   protected array $makeSelectList;

    public function makeUlList($nestedCategories): string
    {
        $makeUlList = '';

        foreach ($nestedCategories as $category)
        {
            $makeUlList .= '<li><a href="http://php-unit-course.loc/show-category/'.$category['id'].','.$category['name'].'">'.$category['name'].'</a>';
            if(!empty($category['children']))
            {
                $makeUlList .= '<ul class="submenu menu vertical" data-submenu>';
                $makeUlList .= $this->makeUlList($category['children']);
                $makeUlList .= '</ul>';
            }
            $makeUlList .= '</li>';
        }

        return $makeUlList;
    }

    public function makeSelectList($nestedCategories, $repeat = 0): array
    {
        foreach ($nestedCategories as $category)
        {
            $this->makeSelectList[] = [
                'id' => $category['id'],
                'name' => str_repeat('&nbsp;', $repeat) . $category['name']
            ];
            if(!empty($category['children']))
            {
                $this->makeSelectList($category['children'], $repeat + 2);
            }

        }
        return $this->makeSelectList;
    }
}