<?php

namespace tumba;

abstract class AbstractController
{
    public array $data = [];
    public array $meta = ['title' => '', 'description' => '', 'keywords' => ''];
    public false|string $layout = '';
    public string $view = '';
    public object $model;

    public function __construct(
        public $route = []

    )
    {
        App::$appReg->setProperty('route', $this->route);
    }

    public function getModel(): void
    {
        $model = 'app\\models\\' . $this->route['admin_prefix'] . $this->route['controller'] . 'Model';
        if (class_exists($model)) {
            $this->model = new $model();
        }
    }

    public function getView(): void
    {
        $this->view = $this->view ?: $this->route['action'];
        $ViewObject = new View($this->route, $this->layout, $this->view, $this->meta);
        $ViewObject->render($this->data);
    }

    public function setData($data): void
    {
        $this->data = $data;
    }

    public function setMeta($title = '', $description = '', $keywords = ''): void
    {
        $this->meta['title'] = $title;
        $this->meta['description'] = $description;
        $this->meta['keywords'] = $keywords;
    }

    public function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    public function loadView($view, $vars = [])
    {
        extract($vars);
        $prefix = str_replace('\\', '/', $this->route['admin_prefix']);
        require APP. "/views/{$prefix}{$this->route['controller']}/{$view}.php";
        die();
    }

    public function error404($controller = 'Error', $view = 404): void
    {
        http_response_code(404);
        $this->setMeta(getLang('tpl_error_404'));
        $this->route['controller'] = $controller;
        $this->view = $view;
    }

}