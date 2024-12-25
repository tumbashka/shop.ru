<?php

namespace tumba;

class App
{
    public static Registry $appReg;

    public function __construct()
    {

        $query = trim(urldecode($_SERVER['QUERY_STRING']),'/');
        new ErrorHandler();
        session_start();
        self::$appReg = Registry::getInstance();
        $this->getParams();
        Router::dispatch($query);
    }
    protected function getParams(): void
    {
        $params = require_once CONFIG.'/params.php';
        if(!empty($params)){
            foreach ($params as $key => $value) {
                self::$appReg->setProperty($key, $value);
            }
        }
    }
}