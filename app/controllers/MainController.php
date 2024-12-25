<?php

namespace app\controllers;

use app\models\MainModel;
use RedBeanPHP\R;
use tumba\App;
use tumba\Cache;

/** @property MainModel $model */
class MainController extends AppController
{
    public function indexAction()
    {


        $lang = App::$appReg->getProperty('language');
        $slides = R::findAll('slider');
        $products = $this->model->getHitProducts($lang, 6);

        $this->setData(compact('products', 'slides'));
        $this->setMeta(
            getLang('main_index_meta_title'),
            getLang('main_index_meta_description'),
            getLang('main_index_meta_keywords')
        );
    }
}