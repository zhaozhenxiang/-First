<?php
//注册地址
define('BASH_PATH', dirname(__DIR__));
//加载启动器
require BASH_PATH . '/bin/autoload.php';
//加载函数
//@todo 以后应该放入composer中
require BASH_PATH . '/bin/func/helpers.php';

//加载路由类
require basePath() . '/bin/route/Route.php';
require basePath() . '/bin/route/RouteAction.php';
//加载路由
require basePath() . '/app/routes.php';
echo RouteAction::action();