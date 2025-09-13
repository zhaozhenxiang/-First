<?php

declare(strict_types=1);

use Bin\Route\RouteAction;

error_reporting(E_ALL ^ E_NOTICE);

define('START_TIME', time());
//注册地址
define('BASE_PATH', dirname(__DIR__));
//加载启动器
require BASE_PATH . '/bin/autoload.php';
$response = RouteAction::action();
echo (string)$response;