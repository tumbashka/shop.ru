<?php

namespace app\controllers;

use app\models\BreadCrumbsModel;
use app\models\ProductModel;
use tumba\App;


/** @property ProductModel $model */
class ProductController extends AppController
{
    public function viewAction()
    {
        $lang = App::$appReg->getProperty('language');
        $product = $this->model->getProduct($this->route['slug'], $lang);

        if(!$product){
            $this->error404();
            return;
//            throw new \Exception("Товар по запросу ({$this->route['slug']}) не найден", 404);
        }

        $breadCrumbs = BreadCrumbsModel::getBreadCrumbs($product['category_id'],$product['title']);
        $gallery = $this->model->get_gallery($product['id']);

        $this->setMeta($product['title'], $product['description'], $product['keywords']);
        $this->setData(compact('product', 'gallery', 'breadCrumbs'));
    }
}