<?php

namespace app\controllers;

use app\models\PageModel;
use tumba\App;

/**
 * @property PageModel $model
*/
class PageController extends AppController
{
    public function viewAction()
    {
        $lang = App::$appReg->getProperty('language');
        $slug = $this->route['slug'];
        $page = $this->model->getPage($slug, $lang);
        if(!$page){
            $this->error404();
            return;
        }
        $this->setMeta($page['title'], $page['keywords'], $page['description']);
        $this->setData(compact('page'));
    }
}