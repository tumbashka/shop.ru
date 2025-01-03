<?php

namespace app\controllers;

use app\models\AppModel;
use app\models\WishlistModel;
use app\widgets\language\Language;
use RedBeanPHP\R;
use tumba\AbstractController;
use tumba\App;

class AppController extends AbstractController
{
    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();


        App::$appReg->setProperty('languages', Language::getLanguages());
        App::$appReg->setProperty('language', Language::getLanguage(App::$appReg->getProperty('languages')));

        $lang = App::$appReg->getProperty('language');
        \tumba\Language::load($lang['code'], $route);

        $categories = R::getAssoc("SELECT c.*, cd.* FROM category c 
                        JOIN category_description cd
                        ON c.id = cd.category_id
                        WHERE cd.language_id = ?", [$lang['id']]);
        App::$appReg->setProperty("categories_{$lang['code']}", $categories);

        App::$appReg->setProperty("wishlist", WishlistModel::getWishlistIDs());

    }

}