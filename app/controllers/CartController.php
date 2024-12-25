<?php

namespace app\controllers;

use app\models\CartModel;
use tumba\App;

/** @property CartModel $model */
class CartController extends AppController
{

    public function addAction()
    {
        $lang = App::$appReg->getProperty('language');
        $id = get('id');
        $qty = get('qty');

        if (!$id) {
            return false;
        }

        $product = $this->model->get_product($id, $lang);
        if (!$product) {
            return false;
        }
        $this->model->add_to_cart($product, $qty);

        if ($this->isAjax()) {
            $this->loadView('cart_modal');
        }
        redirect();
    }

    public function showAction()
    {
        $this->loadView('cart_modal');
    }

    public function deleteAction()
    {
        $id = get('id');
        if (!$id) {
            return false;
        }
        $this->model->delete_from_cart($id);

        if ($this->isAjax()) {
            $this->loadView('cart_modal');
        }
        redirect();
    }

    public function clearAction()
    {
        $this->model->clear_cart();
        $this->loadView('cart_modal');
    }
}