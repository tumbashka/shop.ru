<?php

namespace app\controllers\admin;

use app\models\admin\DownloadModel;
use tumba\App;
use tumba\Pagination;

/**
 * @property DownloadModel $model
 */
class DownloadController extends AppController
{
    public function indexAction()
    {
        $lang = App::$appReg->getProperty('language');
        $page = get('page');
        $perPage = App::$appReg->getProperty('paginationAdminFiles');
        $total = $this->model->getCountFiles();
        $pagination = new Pagination($page, $perPage, $total);
        $startID = $pagination->getStart();
        $files = $this->model->getFiles($startID, $perPage, $lang);

        $title = 'Файлы';
        $this->setData(compact('title', 'total', 'files', 'pagination'));
        $this->setMeta("Админка - {$title}");
    }

    public function addAction()
    {
        if (!empty($_POST)) {
            debug($_POST);
            debug($_FILES);
            if ($this->model->validateFileUpload()) {
                if($this->model->saveFile()){
                    $_SESSION['success'] = 'Файл успешно добавлен';
                }else{
                    $_SESSION['errors'] = 'Ошибка добавления файла';
                }
            }

            redirect();
        }

        $title = 'Добавление файла цифрового товара';
        $this->setData(compact('title'));
        $this->setMeta("Админка - {$title}");
    }

    public function deleteAction()
    {
        $id = get('id');

        if ($this->model->delete($id)) {
            $_SESSION['success'] = 'Файл успешно удален';
        }
        redirect();
    }

}