<?php

namespace tumba;

class App
{
    public static Registry $app;

    public function __construct()
    {
        self::$app = Registry::getInstance();
        $this->getParams();
    }
    protected function getParams(): void
    {
        $params = require_once CONFIG.'/params.php';
        if(!empty($params)){
            foreach ($params as $key => $value) {
                self::$app->setProperty($key, $value);
            }
        }
    }
}