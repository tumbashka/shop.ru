<?php

namespace app\models;

use tumba\App;

class BreadCrumbsModel extends AppModel
{
    public static function getBreadCrumbs($category_id, string $productName = ''): string
    {
        $lang = App::$appReg->getProperty('language')['code'];
        $categories = App::$appReg->getProperty("categories_{$lang}");
        $breadCrumbsArray = self::recursiveGetParts($categories, $category_id);
        $breadCrumbs = "<li class='breadcrumb-item'><a href='" . base_url() . "'>" .
            getLang('tpl_home_breadcrumbs') . "</a></li>";
        if ($breadCrumbsArray) {
            foreach ($breadCrumbsArray as $slug => $title) {
                $breadCrumbs .= "<li class='breadcrumb-item'>
                                    <a href='category/{$slug}'>
                                        {$title}
                                    </a>
                                 </li>";
            }
        }
        if ($productName) {
            $breadCrumbs .= "<li class='breadcrumb-item active'>$productName</li>";
        }
        return $breadCrumbs;
    }

    private static function recursiveGetParts($categories, $id = 0, $parts = []): array|false
    {
        if (isset($categories[$id])) {
            $parts[$categories[$id]['slug']] = $categories[$id]['title'];
            $id = $categories[$id]['parent_id'];
            return self::recursiveGetParts($categories, $id, $parts);
        } else {
            return array_reverse($parts, true);

        }
    }

}