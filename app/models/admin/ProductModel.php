<?php

namespace app\models\admin;

use app\models\AppModel;
use RedBeanPHP\R;
use tumba\App;

class ProductModel extends AppModel
{

    public function getProducts($startID, $perPage, $lang)
    {
        return R::getAll("SELECT p.*, pd.* FROM product AS p 
                JOIN shop.product_description AS pd on p.id = pd.product_id
                WHERE pd.language_id = ?
                LIMIT ?,? ", [$lang['id'], $startID, $perPage]);
    }

    public function getCountProducts(): int
    {
        return R::count('product');
    }

    public function get_downloads($q): array
    {
        $data = [];
        $downloads = R::getAssoc("SELECT digital_id, name FROM shop.digital_description dd
                                WHERE dd.name LIKE ? LIMIT 10", ["%{$q}%"]);
        if ($downloads) {
            $i = 0;
            foreach ($downloads as $id => $title) {
                $data['items'][$i]['id'] = $id;
                $data['items'][$i]['text'] = $title;
                $i++;
            }
        }
        return $data;
    }

    public function productValidate()
    {
        $errors = '';
        if (!is_numeric(post('price'))) {
            $errors .= "Цена должна быть числовым значением<br>";
        }
        if (!is_numeric(post('old_price'))) {
            $errors .= "Старая цена должна быть числовым значением<br>";
        }
        foreach ($_POST['product_description'] as $lang_id => $item) {
            $item['title'] = trim($item['title']);
            $item['excerpt'] = trim($item['excerpt']);
            if (empty($item['title'])) {
                $errors .= "Не заполнено Наименование во вкладке{$lang_id}<br>";
            }
            if (empty($item['excerpt'])) {
                $errors .= "Не заполнено Краткое описание во вкладке{$lang_id}<br>";
            }
        }
        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            return false;
        }
        return true;
    }

    public function saveProduct(): bool
    {
        $langID = App::$appReg->getProperty('language')['id'];
        R::begin();
        try {
            $product = R::dispense('product');
            $product->category_id = post('category_id', 'i');
            $product->price = post('price', 'i');
            $product->old_price = post('old_price', 'i');
            $product->is_digital = post('is_download', 'i') ? 1 : 0;
            $product->status = post('status') ? 1 : 0;
            $product->hit = post('hit') ? 1 : 0;
            $product->price = post('price', 'i');
            $product->img = post('img') ?: NO_IMAGE;
            $product_id = R::store($product);
            $product->slug = self::create_slug('product', 'slug', $_POST['product_description'][$langID]['title'], $product_id);
            R::store($product);

            if (!empty($_POST['is_download'])) {
                R::exec("INSERT INTO product_digital (product_id, digital_id)
                        VALUES (?,?)", [$product_id, post('is_download', 'i')]);
            }

            if (!empty($_POST['gallery'])) {
                foreach ($_POST['gallery'] as $img) {
                    $product_gallery = R::xdispense('product_gallery');
                    $product_gallery->img = $img;
                    $product_gallery->product_id = $product_id;
                    R::store($product_gallery);
                }
            }
            foreach ($_POST['product_description'] as $langID => $item) {
                R::exec("INSERT INTO product_description (product_id, language_id, title, content, excerpt, keywords, description)
                        VALUES (?,?,?,?,?,?,?)", [$product_id, $langID, $item['title'], $item['content'], $item['excerpt'], $item['keywords'], $item['description']]);
            }

            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            $_SESSION['form_data'] = $_POST;
            return false;
        }
    }

    public function getProduct($id)
    {
        return R::getRow("SELECT * FROM shop.product p WHERE p.id = ?", [$id]);
    }

    public function getProductDescription($productID)
    {
        return R::getAssoc("SELECT pd.language_id, pd.* FROM shop.product_description pd WHERE pd.product_id = ?", [$productID]);
    }

    public function getProductDigital($productID)
    {
        return R::getRow("SELECT * FROM shop.product_digital p WHERE p.product_id = ?", [$productID]);
    }

    public function getProductGallery($productID)
    {
        return R::getAll("SELECT * FROM shop.product_gallery pg WHERE pg.product_id = ?", [$productID]);
    }

    public function getDigitalDescription($digitalID, $lang)
    {
        return R::getRow("SELECT * FROM shop.digital_description dd 
                WHERE dd.digital_id = ? AND dd.language_id = ?", [$digitalID, $lang['id']]);
    }

    public function editProduct()
    {
        $langID = App::$appReg->getProperty('language')['id'];
        R::begin();
        try {
            $product_id = get('id');
            foreach ($_POST['product_description'] as $langID => $item) {
                R::exec("UPDATE product_description 
                        SET title = :title, content = :cont, excerpt = :excerpt, keywords = :keyw, description = :descr
                        WHERE product_id = :prod_id AND language_id = :lang_id",
                    [
                        ':title' => $item['title'],
                        ':descr' => $item['description'],
                        ':keyw' => $item['keywords'],
                        ':cont' => $item['content'],
                        ':excerpt' => $item['excerpt'],
                        ':prod_id' => $product_id,
                        ':lang_id' => $langID,
                    ]);
            }
            $slug = self::create_slug('product', 'slug', $_POST['product_description'][$langID]['title'], $product_id);
            R::exec("UPDATE shop.product AS p 
                        SET p.category_id = :cat_id, p.slug = :slug, p.price = :price, p.old_price = :old_price, 
                            p.status = :status, p.hit = :hit, p.img = :img, p.is_digital = :is_digital
                        WHERE p.id = :id",
                [
                    ':cat_id' => post('category_id', 'i'),
                    ':slug' => $slug,
                    ':price' => post('price', 'i'),
                    ':old_price' => post('old_price', 'i'),
                    ':status' => post('status') ? 1 : 0,
                    ':hit' => post('hit') ? 1 : 0,
                    ':img' => post('img') ?: NO_IMAGE,
                    ':is_digital' => post('is_download', 'i') ? 1 : 0,
                    ':id' => $product_id,
                ]);

            R::exec("DELETE FROM shop.product_digital pd WHERE pd.product_id = ?", [$product_id]);

            if (post('is_download')) {
                R::exec("INSERT INTO product_digital (product_id, digital_id)
                        VALUES (?,?)", [$product_id, post('is_download', 'i')]);
            }

            R::exec("DELETE FROM shop.product_gallery pg WHERE pg.product_id = ?", [$product_id]);

            if (!empty($_POST['gallery'])) {
                foreach ($_POST['gallery'] as $img) {
                    $product_gallery = R::xdispense('product_gallery');
                    $product_gallery->img = $img;
                    $product_gallery->product_id = $product_id;
                    R::store($product_gallery);
                }
            }

            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            return false;
        }

    }

}