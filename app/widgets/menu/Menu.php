<?php

namespace app\widgets\menu;

use tumba\App;
use tumba\Cache;

class Menu
{
    protected $data;
    protected $tree;
    protected $menuHTML;
    protected $tpl;
    protected $container = 'ul';
    protected $class = 'menu';
    protected $cacheTime = 3600;
    protected $cacheKey = 'shop_menu';
    protected $attrs = [];
    protected $prepend = '';
    protected $language;

    public function __construct($options = []){
        $this->language = App::$appReg->getProperty('language');
        $this->tpl = __DIR__ . '/menu_tpl.php';
        $this->getOptions($options);
        $this->run();
    }


    protected function getOptions($options){
        foreach($options as $k => $v){
            if(property_exists($this, $k)){
                $this->$k = $v;
            }
        }
    }

    protected function run(){
        $cache = Cache::getInstance();
        $this->menuHTML = $cache->get("{$this->cacheKey}_{$this->language['code']}");

        if(!$this->menuHTML){
            $this->data = App::$appReg->getProperty("categories_{$this->language['code']}");
            $this->tree = $this->getTree();
            $this->menuHTML = $this->getMenuHtml($this->tree);
            if($this->cacheTime){
                $cache->set("{$this->cacheKey}_{$this->language['code']}", $this->menuHTML, $this->cacheTime);
            }
        }

        $this->output();
    }

    protected function getTree()
    {
        $tree = [];

        $data = $this->data;
        foreach ($data as $id => &$node) {
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            } else {
                $data[$node['parent_id']]['children'][$id] = &$node;
            }
        }
        return $tree;
    }

    protected function getMenuHTML($tree, $tab = '')
    {
        $str = '';
        foreach ($tree as $id => $category) {
            $str .= $this->catToTemplate($category, $tab, $id);
        }
        return $str;
    }

    protected function catToTemplate($category, $tab, $id)
    {
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }

    protected function output(){
        $attrs = '';
        if(!empty($this->attrs)){
            foreach ($this->attrs as $k => $v){
                $attrs .= " $k='$v' ";
            }
        }
        echo "<{$this->container} class='{$this->class}' {$attrs}>";
        echo $this->prepend;
        echo $this->menuHTML;
        echo "</{$this->container}>";

    }

}