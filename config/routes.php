<?php

use tumba\Router;

// добавляем регулярные выражения и контроллеры с экшенами по умолчанию
// по типу 'controller' => 'main', 'action' => 'index', 'admin_prefix' => 'admin'

Router::add('^admin/?$', ['controller' => 'main', 'action' => 'index', 'admin_prefix' => 'admin']);
Router::add('^admin/(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?/?$', ['admin_prefix' => 'admin']);

Router::add('^(?P<lang>[a-z]+)?/?product/(?P<slug>[a-z0-9-]+)/?$',['controller' => 'Product', 'action' => 'view']);
Router::add('^(?P<lang>[a-z]+)?/?category/(?P<slug>[a-z0-9-]+)/?$',['controller' => 'Category', 'action' => 'view']);
Router::add('^(?P<lang>[a-z]+)?/?search/?$',['controller' => 'Search', 'action' => 'index']);
Router::add('^(?P<lang>[a-z]+)?/?wishlist/?$',['controller' => 'Wishlist', 'action' => 'index']);
Router::add('^(?P<lang>[a-z]+)?/?page/(?P<slug>[a-z0-9-]+)/?$',['controller' => 'Page', 'action' => 'view']);


Router::add('^(?P<lang>[a-z]+)?/?$', ['controller' => 'main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)/?$');

Router::add('^(?P<lang>[a-z]+)?/?(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)/?$');









