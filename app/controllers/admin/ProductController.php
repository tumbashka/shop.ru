<?php

namespace app\controllers\admin;

use app\models\admin\ProductModel;
use tumba\App;
use tumba\Pagination;

/**
 * @property ProductModel $model
 */
class ProductController extends AppController
{
    public function indexAction()
    {
        $lang = App::$appReg->getProperty('language');

        $page = get('page');
        $perPage = App::$appReg->getProperty('paginationAdminProducts');
        $total = $this->model->getCountProducts();
        $pagination = new Pagination($page, $perPage, $total);
        $startID = $pagination->getStart();

        $products = $this->model->getProducts($startID, $perPage, $lang);

        $title = 'Товары';
        $this->setData(compact('title', 'total', 'products', 'pagination'));
        $this->setMeta("Админка - {$title}");
    }

    public function addAction()
    {
        if (!empty($_POST)) {
            if ($this->model->productValidate()) {
                if ($this->model->saveProduct()) {
                    $_SESSION['success'] = 'Товар успешно добавлен';
                } else {
                    $_SESSION['errors'] = 'Ошибка добавления товара';
                }
            }
            redirect();
        }

        $title = 'Добавление товара';
        $this->setData(compact('title'));
        $this->setMeta("Админка - {$title}");
    }

    public function getDownloadAction()
    {
        $q = get('q', 's');
        $downloads = $this->model->get_downloads($q);
        echo json_encode($downloads);
        die;
    }

    public function editAction()
    {
        $lang = App::$appReg->getProperty('language');
        $id = get("id");
        $product = $this->model->getProduct($id);
        $product_description = $this->model->getProductDescription($id);
        if (empty($product) || empty($product_description)) {
            $_SESSION['errors'] = 'Ошибка изменения товара';
            redirect(ADMIN . '/product');
        }
        App::$appReg->setProperty('parent_id', $product['category_id']);
        $product_digital = [];
        $digital_description = [];
        if ($product['is_digital']) {
            $product_digital = $this->model->getProductDigital($id);
            $digital_description = $this->model->getDigitalDescription($product_digital['digital_id'], $lang);
        }
        $product_gallery = $this->model->getProductGallery($id);

        if (!empty($_POST)) {
            if ($this->model->productValidate()) {
                if ($this->model->editProduct()) {
                    $_SESSION['success'] = 'Товар успешно изменен';
                } else {
                    $_SESSION['errors'] = 'Ошибка изменения товара';
                }
            }
            redirect();
        }
        $title = 'Редактирование товара ' . $this->getProductNameOnAllLangs($product_description);
        $this->setData(compact('product', 'title', 'product_description', 'product_digital', 'product_gallery', 'digital_description'));
        $this->setMeta("Админка - {$title}");
    }

    private function getProductNameOnAllLangs($productArray, $separator = '/'): string
    {
        $nameOnAllLangs = '';
        foreach ($productArray as $product) {
            $nameOnAllLangs .= ucfirst($product['title']);
            $nameOnAllLangs .= $separator;
        }
        return trim($nameOnAllLangs, $separator);
    }
}