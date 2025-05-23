<?php

namespace app\models;

use RedBeanPHP\R;

class MainModel extends AppModel
{
    public function getHitProducts($lang, $limit): array
    {
        return R::getAll("SELECT p.* , pd.* FROM product AS p JOIN product_description AS pd ON p.id = pd.product_id WHERE p.status = 1 AND p.hit = 1 AND pd.language_id = ? LIMIT ?", [$lang['id'], $limit]);
    }
}