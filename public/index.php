<?php

if  (PHP_MAJOR_VERSION < 8){
    die("Необходима версия PHP >= 8.0");
}

require_once dirname(__DIR__) . '/config/init.php';


new \tumba\App();

//echo \tumba\App::$app->getProperty('adminEmail');
//\tumba\App::$app->setProperty('poop', 228);
//var_dump(tumba\App::$app->getProperties());