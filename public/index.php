<?php
//注册地址
define('BASH_PATH', dirname(__DIR__));
//加载启动器
require BASH_PATH . '/bin/autoload.php';
//加载函数
//@todo 以后应该放入composer中
require BASH_PATH . '/bin/helpers.php';

//加载路由类
require BASH_PATH . '/bin/Route.php';
require BASH_PATH . '/app/routes.php';
require BASH_PATH . '/bin/RouteAction.php';

echo RouteAction::action();

