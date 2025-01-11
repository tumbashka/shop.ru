<?php

namespace app\models\admin;

use app\models\AppModel;
use RedBeanPHP\R;
use tumba\App;

class PageModel extends AppModel
{
    public function getPages($startID, $perPage, $lang): array
    {
        return R::getAll("SELECT p.*, pd.title FROM shop.page p 
                    JOIN shop.page_description pd on p.id = pd.page_id
                    WHERE pd.language_Id = ? ORDER BY p.id LIMIT ?,?", [$lang['id'], $startID, $perPage]);
    }

    public function getCountPages()
    {
        return R::count('page');
    }

    public function delete($id): bool
    {
        R::begin();
        try {
            $page = R::count('page', "id = ?", [$id]);
            if (!$page) {
                return false;
            }
            R::exec('DELETE FROM shop.page_description pd WHERE pd.page_id = ?', [$id]);
            R::exec('DELETE FROM shop.page p WHERE p.id = ?', [$id]);
            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            return false;
        }
    }

    public function pageValidate()
    {
        $errors = '';
        foreach ($_POST['page_description'] as $lang_id => $item) {
            $item['title'] = trim($item['title']);
            $item['content'] = trim($item['content']);
            if (empty($item['title'])) {
                $errors .= "Не заполнено Наименование во вкладке{$lang_id}<br>";
            }
            if (empty($item['content'])) {
                $errors .= "Не заполнен контент страницы во вкладке{$lang_id}<br>";
            }
        }
        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            return false;
        }
        return true;
    }

    public function savePage()
    {
        $langID = App::$appReg->getProperty('language')['id'];
        R::begin();
        try {
            $page = R::dispense('page');
            $page_id = R::store($page);
            $page->slug = self::create_slug('page', 'slug', $_POST['page_description'][$langID]['title'], $page_id);
            R::store($page);


            foreach ($_POST['page_description'] as $langID => $item) {
                R::exec("INSERT INTO page_description (page_id, language_id, title, content, keywords, description)
                        VALUES (?,?,?,?,?,?)", [$page_id, $langID, $item['title'], $item['content'], $item['keywords'], $item['description']]);
            }

            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            $_SESSION['form_data'] = $_POST;
            return false;
        }
    }

    public function getPage($id): array
    {
        return R::getRow("SELECT * FROM shop.page p WHERE p.id = ?", [$id]);
    }

    public function getPageDescription($id)
    {
        return R::getAssoc("SELECT pd.language_Id, pd.* FROM shop.page_description pd WHERE pd.page_id = ?", [$id]);
    }

    public function editPage()
    {
        $langID = App::$appReg->getProperty('language')['id'];
        R::begin();
        try {
            $page_id = get('id');
            foreach ($_POST['page_description'] as $langID => $item) {
                R::exec("UPDATE page_description 
                        SET title = :title, content = :cont, keywords = :keyw, description = :descr
                        WHERE page_id = :page_id AND language_id = :lang_id",
                    [
                        ':title' => $item['title'],
                        ':descr' => $item['description'],
                        ':keyw' => $item['keywords'],
                        ':cont' => $item['content'],
                        ':page_id' => $page_id,
                        ':lang_id' => $langID,
                    ]);
            }
            $slug = self::create_slug('page', 'slug', $_POST['page_description'][$langID]['title'], $page_id);
            R::exec("UPDATE shop.page AS p SET p.slug = :slug WHERE p.id = :id",
                [
                    ':slug' => $slug,
                    ':id' => $page_id,
                ]);

            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            return false;
        }
    }


}