<?php

namespace app\models\admin;

use app\models\AppModel;
use RedBeanPHP\R;

class SliderModel extends AppModel
{

    public function getGallery(): array
    {
        return R::getAssoc("SELECT * FROM shop.slider s");
    }

    public function updateSlider(): void
    {
        if (!isset($_POST['gallery'])) {
            R::exec("DELETE FROM shop.slider");
        } elseif (is_array($_POST['gallery'])) {
            $new_gallery = $_POST['gallery'];
            $gallery = $this->getGallery();
            if ((count($gallery) != count($new_gallery)) || array_diff($gallery, $new_gallery) || array_diff($new_gallery, $gallery)) {
                R::exec("DELETE FROM shop.slider");
                foreach ($new_gallery as $id => $img){
                    $bean_gallery = R::dispense('slider');
                    $bean_gallery->img = $img;
                    R::store($bean_gallery);
                }
            }
        }


    }
}