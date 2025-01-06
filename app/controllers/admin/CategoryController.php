<?php

namespace app\controllers\admin;

use app\models\admin\CategoryModel;
use tumba\App;

/**
 * @property CategoryModel $model
 */
class CategoryController extends AppController
{

    public function indexAction()
    {
        $title = 'Категории';
        $this->setData(compact('title'));
        $this->setMeta("Админка - {$title}");
    }

    public function deleteAction()
    {
        $id = get('id');
        $errors = '';
        $childrenCount = $this->model->getChildrenCount($id);
        $productsCount = $this->model->getCategoryProductsCount($id);
        if ($childrenCount > 0) {
            $errors .= 'В категории есть дочерние категории!';
        }
        if ($productsCount > 0) {
            $errors .= 'В данной категории присутствуют товары!';
        }
        if ($errors != '') {
            $_SESSION['errors'] = $errors;
            redirect();
        }
        if ($this->model->delete($id)) {
            $_SESSION['success'] = 'Категория успешно удалена';
        } else {
            $_SESSION['errors'] = 'Ошибка удаления категории';
        }
        redirect();
    }

    public function addAction()
    {
        if (!empty($_POST)) {
            if ($this->model->categoryValidate()) {
                if ($this->model->saveCategory()) {
                    $_SESSION['success'] = 'Категория успешно сохранена';
                } else {
                    $_SESSION['errors'] = 'Ошибка сохранения категории';
                }
            }
            redirect();
        }
        $title = 'Добавление категории';
        $this->setData(compact('title'));
        $this->setMeta("Админка - {$title}");
    }

    public function editAction()
    {
        $id = get("id");
        $category = $this->model->getCategory($id);
        if (empty($category)) {
            redirect(ADMIN . '/category');
        }
        $lang = App::$appReg->getProperty('language');
        App::$appReg->setProperty('parent_id', $category[$lang['id']]['parent_id']);
        if (!empty($_POST)) {
            if ($this->model->categoryValidate()) {
                if ($this->model->editCategory()) {
                    $_SESSION['success'] = 'Категория успешно изменена';
                } else {
                    $_SESSION['errors'] = 'Ошибка изменения категории';
                }
            }
            redirect();
        }
        $title = 'Редактирование категории ' . $this->getCategoryNameOnAllLangs($category);
        $this->setData(compact('category', 'title'));
        $this->setMeta("Админка - {$title}");
    }

    protected function getCategoryNameOnAllLangs($catArray, $separator = '/'): string
    {
        $nameOnAllLangs = '';
        foreach ($catArray as $category) {
            $nameOnAllLangs .= ucfirst($category['title']);
            $nameOnAllLangs .= $separator;
        }
        return trim($nameOnAllLangs, $separator);
    }


}