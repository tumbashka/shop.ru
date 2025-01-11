<?php

namespace app\controllers\admin;

use app\models\admin\PageModel;
use tumba\App;
use tumba\Pagination;

/**
 * @property PageModel $model
 */
class PageController extends AppController
{
    public function indexAction()
    {
        $lang = App::$appReg->getProperty('language');

        $page = get('page');
        $perPage = App::$appReg->getProperty('paginationAdminProducts');
        $total = $this->model->getCountPages();
        $pagination = new Pagination($page, $perPage, $total);
        $startID = $pagination->getStart();
        $pages = $this->model->getPages($startID, $perPage, $lang);

        $title = 'Страницы';
        $this->setData(compact('title', 'total', 'pages', 'pagination'));
        $this->setMeta("Админка - {$title}");
    }

    public function deleteAction()
    {
        $id = get('id');

        if ($this->model->delete($id)) {
            $_SESSION['success'] = 'Товар успешно удален';
        } else {
            $_SESSION['errors'] = 'Ошибка удаления товара';
        }
        redirect();
    }

    public function addAction()
    {
        if (!empty($_POST)) {
            if ($this->model->pageValidate()) {
                if ($this->model->savePage()) {
                    $_SESSION['success'] = 'Страница успешно добавлена';
                } else {
                    $_SESSION['errors'] = 'Ошибка добавления страницы';
                }
            }
            redirect();
        }

        $title = 'Добавление страницы';
        $this->setData(compact('title'));
        $this->setMeta("Админка - {$title}");
    }

    public function editAction()
    {
        $lang = App::$appReg->getProperty('language');
        $id = get("id");
        $page = $this->model->getPage($id);
        $page_description = $this->model->getPageDescription($id);
        if (empty($page) || empty($page_description)) {
            $_SESSION['errors'] = 'Ошибка изменения страницы';
            redirect(ADMIN . '/page');
        }
        if (!empty($_POST)) {
            if ($this->model->pageValidate()) {
                if ($this->model->editPage()) {
                    $_SESSION['success'] = 'Страница успешно изменена';
                } else {
                    $_SESSION['errors'] = 'Ошибка изменения страницы';
                }
            }
            redirect();
        }

        $title = 'Редактирование страницы';
        $this->setData(compact('title', 'page_description'));
        $this->setMeta("Админка - {$title}");
    }
}