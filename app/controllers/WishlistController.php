<?php

namespace app\controllers;

use app\models\WishlistModel;
use tumba\App;

/**
 * @property WishlistModel $model;
*/
class WishlistController extends AppController
{
    public function indexAction()
    {
        $lang = App::$appReg->getProperty('language');
        $products = $this->model->getWishlistProducts($lang);
        $this->setMeta(getLang('wishlist_index_title'));
        $this->setData(compact('products'));
    }

    public function addAction()
    {
        $id = get('id');
        if (!$id) {
            $answer = [
                'result' => 'error',
                'text' => getLang('tpl_wishlist_add_error'),
            ];
            exit(json_encode($answer));
        }

        $productID = $this->model->getProduct($id);
        if($productID){
            $this->model->addProductToWishlist($productID);
            $answer = [
                'result' => 'success',
                'text' => getLang('tpl_wishlist_add_success'),
            ];
        }else{
            $answer = [
                'result' => 'error',
                'text' => getLang('tpl_wishlist_add_error'),
            ];
        }
        exit(json_encode($answer));
    }

    public function deleteAction()
    {
        $id = get('id');
        if (!$id) {
            $answer = [
                'result' => 'error',
                'text' => getLang('tpl_wishlist_delete_error'),
            ];
            exit(json_encode($answer));
        }
        if($this->model->isWishlistProduct($id)){
            $this->model->deleteProductFromWishlist($id);
            $answer = [
                'result' => 'success',
                'text' => getLang('tpl_wishlist_delete_success'),
            ];
        }else{
            $answer = [
                'result' => 'error',
                'text' => getLang('tpl_wishlist_delete_error'),
            ];
        }
        if (!$this->isAjax()) {
            redirect($_SERVER['HTTP_REFERER']);

        }

        exit(json_encode($answer));
    }

}