<?php

namespace app\models;

use RedBeanPHP\R;
use tumba\App;

class CartModel extends AppModel
{

    public function get_product($id, $lang): array
    {
        return R::getRow("SELECT p.*, pd.* FROM product p 
                        JOIN product_description pd ON p.id=pd.product_id 
                        WHERE p.status=1 AND p.id=? AND pd.language_id=?", [$id, $lang['id']]);
    }


    public function add_to_cart($product, $qty = 1)
    {
        if ($qty == 0) {
            $qty = 1;
        }
        $qty = abs($qty);
        if ($product['is_digital'] && isset($_SESSION['cart'][$product['id']])) {
            return false;
        }

        if (isset($_SESSION['cart'][$product['id']])) {
            $_SESSION['cart'][$product['id']]['qty'] += $qty;
        } else {
            if ($product['is_digital']) {
                $qty = 1;
            }
            $_SESSION['cart'][$product['id']] = [
                'title' => $product['title'],
                'slug' => $product['slug'],
                'price' => $product['price'],
                'img' => $product['img'],
                'qty' => $qty,
                'is_digital' => $product['is_digital'],
            ];
        }
        $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;
        $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qty * $product['price'] : $qty * $product['price'];
        return true;
    }

    public function delete_from_cart($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            $delQty = $_SESSION['cart'][$id]['qty'];
            $delSum = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];
            $_SESSION['cart.qty'] -= $delQty;
            $_SESSION['cart.sum'] -= $delSum;
            unset($_SESSION['cart'][$id]);
            return true;
        }
        return false;
    }

    public function clear_cart()
    {
        if (isset($_SESSION['cart'])) {
            unset($_SESSION['cart']);
            unset($_SESSION['cart.qty']);
            unset($_SESSION['cart.sum']);
        }
    }

    public static function translateCart($lang)
    {
        if (empty($_SESSION['cart'])) {
            return false;
        }

        $idString = implode(',', array_keys($_SESSION['cart']));
        $products = R::getAll("SELECT p.id, pd.title FROM product p JOIN product_description pd ON p.id=pd.product_id WHERE p.id IN ($idString) AND pd.language_id=?", [$lang['id']]);
        foreach ($products as $product) {
            $_SESSION['cart'][$product['id']]['title'] = $product['title'];
        }
        return true;

    }
}