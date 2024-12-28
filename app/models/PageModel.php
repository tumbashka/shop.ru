<?php

namespace app\models;

use RedBeanPHP\R;

class PageModel extends AppModel
{
    public function getPage($slug, $language)
    {
        return R::getRow('SELECT p.*, pd.* FROM page AS p 
                        JOIN shop.page_description pd on p.id = pd.page_id
                        WHERE p.slug = ? AND pd.language_Id = ?', [$slug, $language['id']]);
    }
}