<?php
$route = new \Bin\Route\Route();
$route::get('/get/callback', function(){
    return __LINE__;
});

$route::get('/get/view', 'AA@BB');
$route::get('/rel', 'AA@rel');

//post请求
$route::post('/post/1', 'AA@postA');

//todo 开始处理middle相关的代码
$route::middle([], function() use ($route){
    $route::get('/middle/1', 'AA@middle');
});