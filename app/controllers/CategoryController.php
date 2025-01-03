<?php

namespace app\controllers;

use app\models\BreadCrumbsModel;
use app\models\CategoryModel;
use tumba\App;
use tumba\Pagination;

/** @property CategoryModel $model */
class CategoryController extends AppController
{

    public function viewAction()
    {
        $lang = App::$appReg->getProperty('language');
        $category = $this->model->getCategory($this->route['slug'], $lang);

        if (!$category) {
            $this->error404();
            return;
        }

        $breadCrumbs = BreadCrumbsModel::getBreadCrumbs($category['id']);

        $categoryIDs = $this->model->getCurrentAndChildCategoriesIDs($category['id']);

        $page = get('page');
        $sort = get('sort', 's');

        $perPage = get('per_page');
        if (!$this->model->isCorrectPerPage($perPage)) {
            $perPage = App::$appReg->getProperty('paginationProducts');
        }


        $total = $this->model->getCount($categoryIDs);

        $pagination = new Pagination($page, $perPage, $total);
        $startProductID = $pagination->getStart();


        $products = $this->model->getProducts($categoryIDs, $lang, $startProductID, $perPage, $sort);
        $this->setMeta($category['title'], $category['description'], $category['keywords']);
        $this->setData(compact('products', 'category', 'breadCrumbs', 'total', 'pagination'));
    }


}