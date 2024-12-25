<?php

namespace tumba;

class Router
{

    protected static array $routes = [];
    protected static array $route = [];

    public static function add($regexp, $route = []): void
    {
        self::$routes[$regexp] = $route;
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }

    public static function getRoute(): array
    {
        return self::$route;
    }


    public static function dispatch($url): void
    {
        $url = self::removeQueryString($url);
        if (self::matchRoute($url)) {
//            debug(self::$route);
            if(!empty(self::$route['lang'])) {
                App::$appReg->setProperty('lang', self::$route['lang']);
            }
            $controller = self::getFormattedControllerPath();
            if (class_exists($controller)) {
                /** @var AbstractController $controllerObject */
                $controllerObject = new $controller(self::$route);
                $controllerObject->getModel();
                $action = self::getFormattedActionName();
                if (method_exists($controllerObject, $action)) {
                    $controllerObject->$action();
                    $controllerObject->getView();
                } else {
                    throw new \Exception("Метод {$controller}::{$action} не найден", 404);
                }
            } else {
                throw new \Exception("Контроллер {$controller} не найден", 404);
            }
        } else {

            throw new \Exception("Страница не найдена", 404);
        }
    }

    public static function matchRoute($url): bool
    {
        foreach (self::$routes as $regexp => $route) {
            if (preg_match("#{$regexp}#", $url, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        // добавляем в маршрут с действиями по умолчанию
                        // контроллер и экшен из url если он прошел регулярку
                        $route[$key] = $value;
                    }
                }
                if (empty($route['action'])) {
                    $route['action'] = 'index';
                }
                if (!isset($route['admin_prefix'])) {
                    $route['admin_prefix'] = '';
                } else {
                    $route['admin_prefix'] .= '\\';
                }
                $route['controller'] = self::toUpperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    protected static function toUpperCamelCase(string $string, string $separator = '-'): string
    {
        $string = ucwords($string, $separator);
        return str_replace($separator, '', $string);
    }

    protected static function toLowerCamelCase(string $string, string $separator = '-'): string
    {
        $string = self::toUpperCamelCase($string, $separator);
        return lcfirst($string);
    }

    protected static function getFormattedControllerPath(): string
    {
        $controller = 'app\controllers\\';
        $controller .= self::$route['admin_prefix'];
        $controller .= self::$route['controller'] . 'Controller';
        return $controller;
    }

    protected static function getFormattedActionName(): string
    {
        return self::toLowerCamelCase(self::$route['action'] . 'Action');
    }

    protected static function removeQueryString(string $url): string
    {
        if ($url) {
            $params = explode('&', $url, 2);
           if(false === str_contains($params[0], '=')) {
               return rtrim($params[0],'/');
           }
        }
        return '';
    }

}

