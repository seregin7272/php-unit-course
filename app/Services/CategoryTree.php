<?php
declare(strict_types=1);

namespace App\Services;

class CategoryTree
{
    public function convert(array $dbRes, $parentId = null): array
    {
        $nested = [];
        foreach ($dbRes as $category)
        {
            $category['children'] = [];
           if($category['parent_id'] === $parentId)
           {
               $children = $this->convert($dbRes, $category['id']);
               if ($children)
               {
                   $category['children'] = $children;
               }
               $nested[] = $category;
           }

        }
        return $nested;
    }
}