<?php

namespace app\models\admin;

use app\models\AppModel;
use RedBeanPHP\R;
use tumba\App;

class CategoryModel extends AppModel
{
    public function delete($id): bool
    {
        R::begin();
        try {
            R::exec('DELETE FROM category_description WHERE category_id = ?', [$id]);
            R::exec('DELETE FROM category WHERE id = ?', [$id]);
            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            return false;
        }
    }

    public function getChildrenCount($id): int
    {
        return R::count('category', 'parent_id=?', [$id]);
    }

    public function getCategoryProductsCount($id): int
    {
        return R::count('product', 'category_id=?', [$id]);
    }

    public function categoryValidate(): bool
    {
        $errors = '';
        foreach ($_POST['category_description'] as $langID => $item) {
            if (empty($item['title'])) {
                $errors .= "Наименование во вкладке {$langID} не заполнено!<br>";
            }
        }
        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            return false;
        }
        return true;
    }

    public function saveCategory(): bool
    {
        $langID = App::$appReg->getProperty('language')['id'];
        R::begin();
        try {
            $category = R::dispense('category');
            $category->parent_id = post('parent_id', 'i');
            $category_id = R::store($category);
            $category->slug = self::create_slug('category', 'slug', $_POST['category_description'][$langID]['title'], $category_id);
            R::store($category);

            foreach ($_POST['category_description'] as $langID => $item) {
                R::exec("INSERT INTO category_description (category_id, language_id, title, description, keywords, content) 
                        VALUES (?,?,?,?,?,?)", [$category_id, $langID, $item['title'], $item['description'], $item['keywords'], $item['content']]);
            }

            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            $_SESSION['form_data'] = $_POST;
            return false;
        }
    }

    public function getCategory($id): array
    {
        return R::getAssoc("SELECT cd.language_id, cd.*, c.*  FROM category AS c 
                    JOIN shop.category_description AS cd on c.id = cd.category_id
                    WHERE c.id = ?", [$id]);
    }

    public function editCategory()
    {
        $langID = App::$appReg->getProperty('language')['id'];
        R::begin();
        try {
            $parentId = post('parent_id', 'i');
            $category_id = get('id');
            $slug = self::create_slug('category', 'slug', $_POST['category_description'][$langID]['title'], $category_id);
            R::exec("UPDATE category SET parent_id = ?, slug = ? WHERE id = ?", [$parentId, $slug, $category_id]);

            foreach ($_POST['category_description'] as $langID => $item) {
                R::exec("UPDATE category_description 
                        SET title = :title, description = :descr, keywords = :keyw, content = :cont
                        WHERE category_id = :cat_id AND language_id = :lang_id",
                    [
                        ':title' => $item['title'],
                        ':descr' => $item['description'],
                        ':keyw' => $item['keywords'],
                        ':cont' => $item['content'],
                        ':cat_id' => $category_id,
                        ':lang_id' => $langID,
                    ]);
            }

            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            return false;
        }
    }
}