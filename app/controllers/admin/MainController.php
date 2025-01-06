<?php

namespace app\controllers\admin;

use app\models\admin\DashboardModel;

class MainController extends AppController
{
    public function indexAction()
    {
        $dashboardModel = new DashboardModel();
        $allOrdersCount = $dashboardModel->getAllOrdersCount();
        $newOrdersCount = $dashboardModel->getNewOrdersCount();
        $userCount = $dashboardModel->getUserCount();
        $productCount = $dashboardModel->getProductCount();
        $categoriesCount = $dashboardModel->getCategoryCount();

        $this->setMeta('Админка - Главная страница');
        $title = 'Главная страница';
        $this->setData(compact('title', 'allOrdersCount', 'newOrdersCount', 'userCount', 'productCount', 'categoriesCount'));
    }
}