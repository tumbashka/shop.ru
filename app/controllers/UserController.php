<?php

namespace app\controllers;


use app\models\OrderModel;
use app\models\UserModel;
use tumba\App;
use tumba\Pagination;

/**
 * @property UserModel $model
 */
class UserController extends AppController
{
    public function signupAction()
    {
        if (UserModel::isAuthorized()) {
            redirect(base_url());
        }

        if (!empty($_POST)) {
            $this->model->load();
            if (!$this->model->validate($this->model->attributes) || !$this->model->isUniqueEmail()) {
                $this->model->getErrors();
                $_SESSION['form_data'] = $this->model->attributes;
            } else {
                $this->model->attributes['password'] = password_hash($this->model->attributes['password'], PASSWORD_DEFAULT);
                if ($this->model->save('user')) {
                    $_SESSION['success'] = getLang('user_signup_success_registration');
                } else {
                    $_SESSION['errors'] = getLang('user_signup_error_registration');
                }
            }
            redirect();
        }
        $this->setMeta(getLang('tpl_signup'));
    }

    public function signinAction()
    {
        if (UserModel::isAuthorized()) {
            redirect(base_url());
        }

        if (!empty($_POST)) {
            if ($this->model->signin()) {
                $_SESSION['success'] = getLang('user_signin_success_signin');
                redirect(base_url());
            } else {
                $_SESSION['errors'] = getLang('user_signin_error_signin');
                redirect();
            }

        }

        $this->setMeta(getLang('tpl_signin'));
    }

    public function logoutAction()
    {
        if (UserModel::isAuthorized()) {
            unset($_SESSION['user']);
            redirect(base_url() . 'user/signin');
        }
    }

    public function cabinetAction()
    {
        if (!UserModel::isAuthorized()) {
            redirect(base_url() . 'user/signin');
        }
        $this->setMeta(getLang('tpl_cabinet'));
    }

    public function ordersAction()
    {
        if (!UserModel::isAuthorized()) {
            redirect(base_url() . 'user/signin');
        }
        $page = get('page');
        $perPage = App::$appReg->getProperty('paginationCabinet');
        $orderModel = new OrderModel();
        $total = $orderModel->getUserCountOrders($_SESSION['user']['id']);
        $pagination = new Pagination($page, $perPage, $total);
        $start = $pagination->getStart();

        $orders = $orderModel->getUserOrders($_SESSION['user']['id'], $start, $perPage);

        $this->setData(compact('orders', 'pagination', 'total'));
        $this->setMeta(getLang('tpl_orders'));
    }

    public function orderAction()
    {
        if (!UserModel::isAuthorized()) {
            redirect(base_url() . 'user/signin');
        }
        $orderId = get('id');
        $orderModel = new OrderModel();
        $order = $orderModel->getUserOrder($orderId, $_SESSION['user']['id']);

        if (!$order) {
            $this->error404();
            return;
        }

        $orderProducts = $orderModel->getUserOrderProducts($order['id']);

        $this->setData(compact('order', 'orderProducts'));
        $this->setMeta(sprintf(getLang('user_order_order_num'), $order['id']));
    }

    public function filesAction()
    {
        if (!UserModel::isAuthorized()) {
            redirect(base_url() . 'user/signin');
        }
        $language = App::$appReg->getProperty('language');
        $page = get('page');
        $perPage = App::$appReg->getProperty('paginationCabinet');
        $orderModel = new OrderModel();
        $total = $orderModel->getUserCountDigitalProducts($_SESSION['user']['id']);
        $pagination = new Pagination($page, $perPage, $total);
        $start = $pagination->getStart();

        $files = $orderModel->getUserDigitalProducts($_SESSION['user']['id'], $start, $perPage, $language);
//        debug($files,1);
        $this->setData(compact('files', 'pagination', 'total'));
        $this->setMeta(getLang('tpl_orders_files'));

    }

    public function downloadAction()
    {
        if (!UserModel::isAuthorized()) {
            redirect(base_url() . 'user/signin');
        }
        $digitalId = get('id');
        $language = App::$appReg->getProperty('language');
        $orderModel = new OrderModel();
        $file = $orderModel->getUserDigitalProduct($_SESSION['user']['id'], $digitalId, $language);
        if ($file) {
            $path = WWW . '/downloads/' . $file['filename'];
            if (file_exists($path)) {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($file['original_name']) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Content-Length: .filesize($path)');
                readfile($path);
                exit();
            } else {
                $_SESSION['errors'] = getLang('user_files_download_error');
            }
        }
        redirect();
    }

    public function credentialsAction()
    {
        if (!UserModel::isAuthorized()) {
            redirect(base_url() . 'user/signin');
        }

        if (!empty($_POST)) {
            $this->model->load();
            if (empty($this->model->attributes['password'])) {
                unset($this->model->attributes['password']);
            }
            unset($this->model->attributes['email']);
            if (!$this->model->validate($this->model->attributes)) {
                $this->model->getErrors();
            } else {
                if (!empty($this->model->attributes['password'])) {
                    $this->model->attributes['password'] = password_hash($this->model->attributes['password'], PASSWORD_DEFAULT);
                }
                if ($this->model->update('user', $_SESSION['user']['id'])) {
                    $_SESSION['success'] = getLang('user_credentials_success');
                    foreach ($this->model->attributes as $key => $value) {
                        if (!empty($value) && $key != 'password') {
                            $_SESSION['user'][$key] = $value;
                        }
                    }
                } else {
                    $_SESSION['errors'] = getLang('user_credentials_error');
                }
            }
            redirect();
        }
        $this->setMeta(getLang('tpl_user_credentials'));
    }
}