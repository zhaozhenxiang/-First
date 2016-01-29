<?php
$route = new \Bin\Route\Route();
$route::get('/a', function(){
    return __LINE__;
});

$route::get('/b', 'AA@BB');