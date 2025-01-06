<?php

define("DEBUG", 1);
define("ROOT", dirname(__DIR__));
define("WWW", ROOT . '/public');
define("APP", ROOT . '/app');
define("CORE", ROOT . '/vendor/tumba');
define("HELPERS", ROOT . '/vendor/tumba/helpers');
define("CACHE", ROOT . '/tmp/cache');
define("LOGS", ROOT . '/tmp/logs');
define("CONFIG", ROOT . '/config');
define("LAYOUT", 'shop');
define("PATH", 'http://shop.ru');
define("ADMIN", 'http://shop.ru/admin');
define("NO_IMAGE", '/public/uploads/no_image.jpg');

require_once ROOT . '/vendor/autoload.php';