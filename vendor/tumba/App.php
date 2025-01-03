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
        $this->getParams(CONFIG.'/params.php');
        $this->getParams(CONFIG.'/smtp.php');
        Router::dispatch($query);
    }
    protected function getParams($path): void
    {
        $params = require_once $path;
        if(!empty($params)){
            foreach ($params as $key => $value) {
                self::$appReg->setProperty($key, $value);
            }
        }
    }
}