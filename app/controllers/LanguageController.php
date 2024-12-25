<?php

namespace app\controllers;

use app\models\CartModel;
use tumba\App;

class LanguageController extends AppController
{
    public function changeAction()
    {
        $lang = get('lang','s');
        if ($lang) {
            if (array_key_exists($lang, App::$appReg->getProperty('languages'))) {
                $url = trim(str_replace(PATH, '', $_SERVER['HTTP_REFERER']), '/');
                $urlParts = explode('/', $url, 2);
                if (array_key_exists($urlParts[0], App::$appReg->getProperty('languages'))) {
                    if ($lang != APP::$appReg->getProperty('language')['code']) {
                        $urlParts[0] = $lang;
                    } else {
                        array_shift($urlParts);
                    }
                } else {
                    if ($lang != APP::$appReg->getProperty('language')['code']) {
                        array_unshift($urlParts, $lang);
                    }
                }
                $url = PATH. '/' . implode('/', $urlParts);
                CartModel::translateCart(APP::$appReg->getProperty('languages')[$lang]);
                redirect($url);
            }
        }
        redirect();
    }
}