<?php

namespace app\controllers\admin;

use app\models\admin\UserModel;
use app\models\AppModel;
use app\widgets\language\Language;
use RedBeanPHP\R;
use tumba\AbstractController;
use tumba\App;

class AppController extends AbstractController
{
    public false|string $layout = 'admin';

    public function __construct($route = [])
    {
        parent::__construct($route);

        if (!UserModel::isAdmin() && $route['action'] != 'signin-admin') {
            redirect(ADMIN . '/user/signin-admin');
            return;
        }

        new AppModel();
        App::$appReg->setProperty('languages', Language::getLanguages());
        App::$appReg->setProperty('language', Language::getLanguage(App::$appReg->getProperty('languages')));

        $lang = App::$appReg->getProperty('language');
        $categories = R::getAssoc("SELECT c.*, cd.* FROM category AS c
                                JOIN shop.category_description cd ON c.id = cd.category_id
                                WHERE cd.language_id = ?", [$lang['id']]);
        App::$appReg->setProperty('categories_' . $lang['code'], $categories);

    }


}