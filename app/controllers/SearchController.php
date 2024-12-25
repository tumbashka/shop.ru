<?php

namespace app\controllers;

use app\models\SearchModel;
use tumba\App;
use tumba\Pagination;

/**
 * @property SearchModel $model
 *
 */
class SearchController extends AppController
{
    public function indexAction()
    {
        $s = get('s', 's');
        $lang = App::$appReg->getProperty('language');
        $page = get('page');
        $countProducts = $this->model->getCountFoundedProducts($s, $lang);
        $perPage = App::$appReg->getProperty('pagination');
        $pagination = new Pagination($page, $perPage, $countProducts);

        $products = $this->model->getFoundedProducts($s, $lang, $pagination->getStart(), $perPage);
        $this->setMeta(getLang('search_index_search') . ': ' . $s);
        $this->setData(compact('products', 'pagination', 'countProducts', 's'));
//        debug($products, 1);
    }
}