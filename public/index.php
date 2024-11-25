<?php

if  (PHP_MAJOR_VERSION < 8){
    die("Необходима версия PHP >= 8.0");
}

require_once dirname(__DIR__) . '/config/init.php';


new \tumba\App();











