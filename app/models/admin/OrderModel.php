<?php

namespace app\models\admin;

use app\models\AppModel;
use RedBeanPHP\R;

class OrderModel extends AppModel
{

    public function getCountOrders()
    {
        return R::count('orders');
    }
    public function getCountUserOrders($user_id)
    {
        return R::count('orders', 'user_id = ?',[$user_id]);
    }

    public function getUserOrders(int $userID, int $startID, int $perPage): array
    {
        return R::getAll("SELECT * FROM shop.orders o WHERE o.user_id = ? LIMIT ?,?",
            [$userID, $startID, $perPage]);
    }

    public function getOrders(int $startID, int $perPage, bool|int $status = false): array
    {
        if ($status !== false) {
            $statusOption = "WHERE o.status = {$status}";
        } else {
            $statusOption = '';
        }
        return R::getAll("SELECT * FROM shop.orders o {$statusOption} LIMIT ?,?", [$startID, $perPage]);
    }

    public function getOrderDetailed($id)
    {
        return R::getAll("SELECT o.*, op.* FROM shop.orders o 
                        JOIN shop.order_product op on o.id = op.order_id
                        WHERE o.id = ?", [$id]);
    }

    public function changeStatus($id, $status)
    {
        R::begin();
        try {
            R::exec("UPDATE orders SET orders.status = ? WHERE orders.id = ?", [$status, $id]);
            R::exec("UPDATE shop.order_digital od SET od.status = ? WHERE od.order_id = ?", [$status, $id]);
            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            return false;
        }

    }

}