<?php

namespace app\widgets\page;

use RedBeanPHP\R;
use tumba\App;
use tumba\Cache;

class Page
{
    protected $language;
    protected string $container = 'ul';
    protected string $class = 'page-menu';
    protected int $cacheTime = 3600;
    protected string $cacheKey = 'shop_page_menu';
    protected string $menuPageHtml;
    protected string $prepend = '';
    protected $data;

    public function __construct($options = [])
    {
        $this->language = App::$appReg->getProperty('language');
        $this->getOptions($options);
        $this->run();
    }

    public function getOptions(array $options)
    {
        foreach ($options as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    protected function run()
    {
        $cache = Cache::getInstance();
        $this->menuPageHtml = $cache->get("{$this->cacheKey}_{$this->language['code']}");

        if (!$this->menuPageHtml) {
            $this->data = R::getAssoc("SELECT p.*, pd.* FROM page AS p
                                    JOIN shop.page_description pd on p.id = pd.page_id
                                    WHERE pd.language_Id = ?", [$this->language['id']]);
            $this->menuPageHtml = $this->getMenuPageHtml();
            if ($this->cacheTime) {
                $cache->set("{$this->cacheKey}_{$this->language['code']}", $this->menuPageHtml, $this->cacheTime);
            }
        }
        $this->output();
    }

    protected function getMenuPageHtml(){
        $html = '';
        foreach ($this->data as $key => $value) {
            $html .= "<li><a href='page/{$value['slug']}'>{$value['title']}</a></li>";
        }
        return $html;
    }

    protected function output(){
        echo "<{$this->container} class='{$this->class}'>";
        echo $this->prepend;
        echo $this->menuPageHtml;
        echo "</{$this->container}>";
    }


}