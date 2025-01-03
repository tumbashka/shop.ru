<?php

namespace app\models;

use PHPMailer\PHPMailer\PHPMailer;
use RedBeanPHP\R;
use tumba\App;

class OrderModel extends AppModel
{
    public static function saveOrder($data): int|bool
    {
        R::begin();
        try {
            $order = R::dispense('orders');
            $order->user_id = $data['user_id'];
            $order->note = $data['note'];
            $order->total = $_SESSION['cart.sum'];
            $order->qty = $_SESSION['cart.qty'];
            $order_id = R::store($order);
            self::saveOrderProduct($order_id, $data['user_id']);

            R::commit();
            return $order_id;
        } catch (\Exception $e) {
            R::rollback();
            return false;
        }

    }

    public static function saveOrderProduct($order_id, $user_id)
    {
        $sql_part = '';
        $binds = [];
        foreach ($_SESSION['cart'] as $product_id => $product) {
            //если товар цифровой
            if ($product['is_digital']) {
                $digital_id = R::getCell("SELECT digital_id FROM product_digital WHERE product_id = ?", [$product_id]);
                $order_digital = R::xdispense('order_digital');
                $order_digital->order_id = $order_id;
                $order_digital->user_id = $user_id;
                $order_digital->product_id = $product_id;
                $order_digital->digital_id = $digital_id;
                R::store($order_digital);
            }

            $sum = $product['qty'] * $product['price'];
            $order_product = R::xdispense('order_product');
            $order_product->order_id = $order_id;
            $order_product->product_id = $product_id;
            $order_product->title = $product['title'];
            $order_product->slug = $product['slug'];
            $order_product->qty = $product['qty'];
            $order_product->price = $product['price'];
            $order_product->sum = $sum;
            R::store($order_product);
        }
    }

    public static function mailOrder($order_id, $user_email, $tpl): bool
    {
        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->SMTPDebug = 3;
            $mail->CharSet = 'UTF-8';
            $mail->Host = App::$appReg->getProperty('smtp_host');
            $mail->SMTPAuth = App::$appReg->getProperty('smtp_auth');
            $mail->Username = App::$appReg->getProperty('smtp_username');
            $mail->From = App::$appReg->getProperty('smtp_username');
            $mail->Password = App::$appReg->getProperty('smtp_password');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = App::$appReg->getProperty('smtp_port');
            $mail->isHTML(true);

            $mail->setFrom(App::$appReg->getProperty('smtp_from_email'), App::$appReg->getProperty('site_name'));
            $mail->addAddress($user_email);
            $mail->Subject = sprintf(getLang('cart_checkout_mail_subject'), $order_id);

            ob_start();
            require \APP . "/views/mail/{$tpl}.php";
            $body = ob_get_clean();

            $mail->Body = $body;
            return $mail->send();
        } catch (\Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }

    public function getUserCountOrders($user_id): int
    {
        return R::count('orders', 'user_id = ?', [$user_id]);
    }

    public function getUserOrders($user_id, $startOrderID, $perPage): array
    {
        return R::getAll("SELECT * FROM orders WHERE user_id = ?
                    LIMIT ?, ?", [$user_id, $startOrderID, $perPage]);
    }

    public function getUserOrder($orderId, $user_id): array
    {
        return R::getRow("SELECT *  FROM orders WHERE id = ? AND user_id = ?", [$orderId, $user_id]);
    }

    public function getUserOrderProducts($orderId): array
    {
        return R::getAll("SELECT op.*, p.img FROM order_product AS op 
                    JOIN shop.product p on op.product_id = p.id 
                    WHERE order_id = ?", [$orderId]);
    }

    public function getUserCountDigitalProducts($user_id): int
    {
        return R::count('order_digital', 'user_id = ? AND status = 1', [$user_id]);
    }

    public function getUserDigitalProducts($user_id, $startDigitalID, $perPage, $language): array
    {
        return R::getAll("SELECT od.*, dd.*, d.* FROM order_digital AS od
                        JOIN shop.digital_description AS dd on od.digital_id = dd.digital_id
                        JOIN shop.digital d on d.id = od.digital_id
                        WHERE od.user_id = ? AND od.status = 1 AND dd.language_id = ?
                        ORDER BY od.order_id
                        LIMIT ?, ?", [$user_id, $language['id'], $startDigitalID, $perPage]);
    }

    public function getUserDigitalProduct($user_id, $digitalID, $language)
    {
        return R::getRow("SELECT od.*, dd.*, d.* FROM order_digital AS od
                        JOIN shop.digital_description AS dd on od.digital_id = dd.digital_id
                        JOIN shop.digital d on d.id = od.digital_id
                        WHERE od.user_id = ? AND od.status = 1 AND dd.language_id = ? AND d.id = ?"
                        ,[$user_id, $language['id'], $digitalID]);
    }

}