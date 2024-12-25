<?php

namespace tumba;

class Language
{
    /**
     * @var array Array with ALL translated phrases of page
     */
    public static array $langData = [];
    /**
     * @var array Array with translated phrases of layouts
     */
    public static array $langLayout = [];
    /**
     * @var array Array with translated phrases of views
     */
    public static array $langView = [];

    public static function load($code, $route)
    {
        $langLayout = APP . "/languages/{$code}.php";
        $langView = APP . "/languages/{$code}/{$route['controller']}/{$route['action']}.php";
        if (file_exists($langLayout)) {
            self::$langLayout = require_once $langLayout;
        }
        if (file_exists($langView)) {
            self::$langView = require_once $langView;
        }
        self::$langData = array_merge(self::$langLayout, self::$langView);
    }

    public static function get($key)
    {
        return self::$langData[$key]?? $key;
    }

}