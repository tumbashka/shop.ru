<?php

namespace tumba;

use RedBeanPHP\R;

class View
{
    public string $content = '';

    public function __construct(
        public $route,
        public $layout = '',
        public $view = '',
        public $meta = [],
    )
    {
        if ($this->layout !== false) {
            $this->layout = $this->layout ?: LAYOUT;
        }
    }

    public function render($data): void
    {
        if (is_array($data)) {
            extract($data);
        }
        $prefix = str_replace('\\', '/', $this->route['admin_prefix']);
        $view_file = APP . "/views/{$prefix}{$this->route['controller']}/{$this->view}.php";
        if (is_file($view_file)) {
            ob_start();
            require_once $view_file;
            $this->content = ob_get_clean();
        } else {
            throw new \Exception("Файл отображения {$view_file} не найден", 500);
        }
        if ($this->layout !== false) {
            $layout_file = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($layout_file)) {
                require_once $layout_file;
            } else {
                throw new \Exception("Не найден шаблон {$layout_file}", 500);
            }
        }
    }

    public function getMeta(): string
    {
        $out = '<meta name="description" content="' . h($this->meta['description']) . '">' . PHP_EOL;
        $out .= '<meta name="keywords" content="' . h($this->meta['keywords']) . '">' . PHP_EOL;
        $divider = empty($this->meta['title']) ? '' : ' - ';
        $out .= '<title>' . App::$appReg->getProperty('site_name') . $divider . h($this->meta['title']) . '</title>' . PHP_EOL;
        return $out;
    }

    public function getDBLogs()
    {
        if (DEBUG) {
            $logs = R::getDatabaseAdapter()
                ->getDatabase()
                ->getLogger();
            $logs = array_merge($logs->grep('SELECT'), $logs->grep('INSERT')
                , $logs->grep('UPDATE'), $logs->grep('DELETE'));
            debug($logs);
        }
    }

    public function getPart($file, $data = null)
    {
        if (is_array($data)) {
            extract($data);
        }
        $file = APP . "/views/{$file}.php";
        if (is_file($file)) {
            require $file;
        } else {
            echo "File {$file} not found";
        }
    }
}