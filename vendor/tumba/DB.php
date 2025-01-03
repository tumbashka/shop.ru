<?php

namespace tumba;

use RedBeanPHP\R;

class DB
{
    use TSingleton;

    private function __construct()
    {
        $db = require_once CONFIG . '/config_db.php';
        R::setup($db['dsn'], $db['user'], $db['password']);
        if (!R::testConnection()) {
            throw new \Exception('Не удалось подключиться к БД', 500);
        }
        R::freeze();
        if (DEBUG) {
            R::debug(true, 3);
        }
        R::ext('xdispense', function( $type ){
            return R::getRedBean()->dispense( $type );
        });

    }

}