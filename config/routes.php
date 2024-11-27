<?php

use tumba\Router;

// добавляем регулярные выражения и контроллеры с экшенами по умолчанию
// по типу 'controller' => 'main', 'action' => 'index', 'admin_prefix' => 'admin'

Router::add('^admin/?$', ['controller' => 'main', 'action' => 'index', 'admin_prefix' => 'admin']);
Router::add('^admin/(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?/?$', ['admin_prefix' => 'admin']);

Router::add('^$', ['controller' => 'main', 'action' => 'index']);

Router::add('^(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)/?$');










