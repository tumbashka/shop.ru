<?php

namespace app\models\admin;

use app\models\AppModel;
use RedBeanPHP\R;

class DashboardModel extends AppModel
{
    public function getAllOrdersCount(): int
    {
        return R::count('orders');
    }

    public function getNewOrdersCount(): int
    {
        return R::count('orders', 'status=0');
    }

    public function getUserCount(): int
    {
        return R::count('user');
    }

    public function getProductCount(): int
    {
        return R::count('product');
    }

    public function getCategoryCount(): int
    {
        return R::count('category');
    }

}