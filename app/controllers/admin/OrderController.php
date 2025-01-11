<?php

namespace app\controllers\admin;

use app\models\admin\OrderModel;
use app\models\admin\UserModel;
use tumba\App;
use tumba\Pagination;

/**
 * @property OrderModel $model
 */
class OrderController extends AppController
{
    public function indexAction()
    {
        if (isset($_GET['status'])) {
            $status = get('status');
        } else {
            $status = false;
        }
        $page = get('page');
        $perPage = App::$appReg->getProperty('paginationAdminOrders');
        $total = $this->model->getCountOrders();
        $pagination = new Pagination($page, $perPage, $total);
        $startID = $pagination->getStart();
        $orders = $this->model->getOrders($startID, $perPage, $status);

        $title = 'Заказы';
        $this->setData(compact('title', 'orders', 'pagination', 'total'));
        $this->setMeta("Админка - {$title}");

    }

    public function editAction()
    {
        $id = get('id');
        $order = $this->model->getOrderDetailed($id);
        if(empty($order)){
            redirect();
        }
        if (isset($_GET['status'])) {
            $status = get('status');
            if( $this->model->changeStatus($id, $status)){
                $_SESSION['success'] = 'Статус заказа успешно изменен';
            } else{
                $_SESSION['errors'] = 'Ошибка изменения статуса заказа';
            }

        }


        $userModel = new UserModel();
        $user = $userModel->getUser($order['0']['user_id']);
        $title = 'Заказы';
        $this->setData(compact('title', 'order','user'));
        $this->setMeta("Админка - {$title}");
    }

}