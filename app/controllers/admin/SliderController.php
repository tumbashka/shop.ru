<?php

namespace app\controllers\admin;
use app\models\admin\SliderModel;

/**
 * @property SliderModel $model
 */
class SliderController extends AppController
{
    public function indexAction()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $this->model->updateSlider();
//            redirect();
        }

        $gallery = $this->model->getGallery();

        $title = 'Редактирование слайдера';
        $this->setData(compact('title', 'gallery'));
        $this->setMeta("Админка - {$title}");
    }
}