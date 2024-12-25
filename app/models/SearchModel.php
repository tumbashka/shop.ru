<?php

namespace app\models;

use RedBeanPHP\R;

class SearchModel extends AppModel
{
    public function getCountFoundedProducts($s, $lang): int
    {
        return R::getCell('SELECT COUNT(*) FROM product AS p 
                        JOIN shop.product_description pd on p.id = pd.product_id
                        WHERE p.status = 1 AND pd.language_id = ? AND pd.title LIKE ?',[$lang['id'], "%{$s}%"]);
    }

    public function getFoundedProducts($s, $lang, $startProductID, $perPage): array
    {
        return R::getAll("SELECT p.*, pd.* FROM product AS p 
                JOIN shop.product_description AS pd on p.id = pd.product_id
                WHERE p.status = 1 AND pd.language_id = ? AND pd.title LIKE ?
                LIMIT ?,? ", [$lang['id'], "%{$s}%", $startProductID, $perPage]);
    }
}