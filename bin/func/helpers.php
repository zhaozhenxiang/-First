<?php
if (!function_exists('getUrl')) {
    function getUrl()
    {
        return $_SERVER['PATH_INFO'];
    }
}

if (!function_exists('getMethod')) {
    function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
if (!function_exists('basePath')) {
    function basePath()
    {
        return BASE_PATH;
    }
}
//
// 还是等view类写出来之后直接在这个函数里面调用view类的内容
//if (!function_exists('view')) {
//    function view($path)
//    {
//
//    }
//}

if (!function_exists('config')) {
    function config($key, $value = null)
    {
        if (is_null($value)) {
            //按照':'分隔
            $layered = explode(':', $key);

            if (empty($layered)) {
                return null;
            }

            $config = include basePath() . '/config/' . $layered[0] . '.php';
            $tmp = $config;

            //从1开始
            for ($i = 1, $count = count($layered); $i < $count; $i ++) {
                $tmp = $tmp[$layered[$i]];
            }

            return $tmp;
        }
        //@todo 设置key值的段落
    }
}

