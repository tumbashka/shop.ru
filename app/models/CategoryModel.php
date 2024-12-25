<?php

namespace app\models;

use RedBeanPHP\R;
use tumba\App;

class CategoryModel extends AppModel
{
    public function getCategory($slug, $lang): array
    {
        return R::getRow("SELECT c.*, cd.* FROM category AS c 
                    JOIN shop.category_description cd on c.id = cd.category_id 
                    WHERE c.slug = ? AND cd.language_id = ?", [$slug, $lang['id']]);
    }

    public function getCurrentAndChildCategoriesIDs($id): string
    {
        return trim($id . ',' . $this->getChildCategoriesIDs($id), ',');
    }

    private function getChildCategoriesIDs($id): string
    {
        $lang = App::$appReg->getProperty('language')['code'];
        $categories = App::$appReg->getProperty("categories_{$lang}");
        $idArr = '';
        foreach ($categories as $key => $category) {
            if ($category['parent_id'] == $id) {
                $idArr .= $key . ',';
                $idArr .= $this->getChildCategoriesIDs($key);
            }
        }
        return $idArr;
    }

    public function getProducts($categoryIDs, $lang, $startProductID, $perPage, $sort_val): array
    {
        $orderBy = $this->getOrderBy($sort_val);
        return R::getAll("SELECT p.*, pd.* FROM product AS p 
                JOIN shop.product_description AS pd on p.id = pd.product_id
                WHERE p.status = 1 AND p.category_id IN ({$categoryIDs}) AND pd.language_id = ?  
                {$orderBy}
                LIMIT ?,? ", [$lang['id'], $startProductID, $perPage]);
    }

    private function getOrderBy($sort_val): string
    {
        $sort_values = [
            'title_asc' => 'ORDER BY pd.title ASC',
            'title_desc' => 'ORDER BY pd.title DESC',
            'price_asc' => 'ORDER BY p.price ASC',
            'price_desc' => 'ORDER BY p.price DESC',
        ];
        if (!isset($sort_values[$sort_val]) || !array_key_exists($sort_val, $sort_values)) {
            $sort_val = 'title_asc';
        }

        return $sort_values[$sort_val];
    }


    public function getCount($ids): int
    {
        return R::count('product', "status = 1 AND category_id IN ({$ids})");
    }

    public function isCorrectPerPage(int $per_page): bool
    {
        $correctValues = [5, 10, 20, 50];
        return in_array($per_page, $correctValues);
    }

}