<?php

namespace app\controllers\admin;

use app\models\admin\CacheModel;
use app\widgets\menu\Menu;
use app\widgets\page\Page;
use tumba\App;

/**
 * @property CacheModel $model
 */
class CacheController extends AppController
{
    public function indexAction()
    {
        $title = 'Управление кэшем';
        $this->setData(compact('title'));
        $this->setMeta("Админка - {$title}");
    }

    public function deleteAction()
    {
        $success = '';
        $errors = '';
        $cacheKey = get('cache', 's');
        switch ($cacheKey) {
            case 'page':
                $cacheKey = 'shop_menu';
                break;
            case 'category':
                $cacheKey = 'shop_page_menu';
                break;
        }
        $langs = App::$appReg->getProperty('languages');
        foreach ($langs as $code => $lang) {
            if ($this->model->deleteCache("{$cacheKey}_{$code}")) {
                $success .= "Кеш с ключом: {$cacheKey}_{$code} успешно удален<br>";
            } else
                $errors .= "Ошибка удаления кэша с ключом: {$cacheKey}_{$code}<br>";
        }
        if ($success) {
            $_SESSION['success'] = $success;
        }
        if ($errors) {
            $_SESSION['errors'] = $errors;
        }

        redirect(ADMIN . '/cache');
    }

}