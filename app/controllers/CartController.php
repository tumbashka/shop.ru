<?php

namespace app\controllers;

use app\models\CartModel;
use app\models\OrderModel;
use app\models\UserModel;
use tumba\App;

/** @property CartModel $model */
class CartController extends AppController
{

    public function addAction(): bool
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

    public function deleteAction(): bool
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

    public function viewAction()
    {
        $this->setMeta(getLang('tpl_cart'));
    }

    public function checkoutAction()
    {
        if (!empty($_POST)) {
//            регистрация пользователя, если он не авторизован
            if (!UserModel::isAuthorized()) {
                $user = new UserModel();
                $user->load();
                if (!$user->validate($user->attributes) || !$user->isUniqueEmail()) {
                    $user->getErrors();
                    $_SESSION['form_data'] = $user->attributes;
                    redirect();
                } else {
                    $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                    if (!$user_id = $user->save('user')) {
                        $_SESSION['errors'] = getLang('cart_checkout_error_register');
                        redirect();
                    }
                }
            }

//            сохранение заказа
            $data['user_id'] = $user_id ?? $_SESSION['user']['id'];
            $data['note'] = post('note');
            $user_email = $_SESSION['user']['email'] ?? post('email');

            if (!$order_id = OrderModel::saveOrder($data)) {
                $_SESSION['errors'] = getLang('cart_checkout_error_save_order');
            } else {
                OrderModel::mailOrder($order_id, $user_email, 'mail_order_user');
                $admin_email = App::$appReg->getProperty('adminEmail');
                OrderModel::mailOrder($order_id, $admin_email, 'mail_order_admin');

                unset($_SESSION['cart']);
                unset($_SESSION['cart.sum']);
                unset($_SESSION['cart.qty']);
                $_SESSION['success'] = getLang('cart_checkout_order_success');
            }

        }
        redirect();
    }
}