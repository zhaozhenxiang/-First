<?php
//注册地址
define('BASE_PATH', dirname(__DIR__));
//加载启动器
require BASE_PATH . '/bin/autoload.php';
echo \Bin\Route\RouteAction::action();