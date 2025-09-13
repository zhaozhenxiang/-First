<?php

declare(strict_types=1);

use Bin\App\App;

if (!function_exists('getUrl')) {
    /**
     * 获取url
     * @return string
     */
    function getUrl(): string
    {
        return $_SERVER['REQUEST_URI'];
    }
}

if (!function_exists('getMethod')) {
    /**
     * 获取方法
     * @return string
     */
    function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
if (!function_exists('basePath')) {
    /**
     * 获取路径
     * @return string
     */
    function basePath(): string
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
    /**
     *
     * @param  string  $key
     * @param          $value
     * @return mixed
     */
    function config(string $key, mixed $value = null): mixed
    {
        if (null === $value) {
            //按照':'分隔
            $layered = explode(':', $key);

            if (empty($layered)) {
                return null;
            }

            $config = include basePath() . '/config/' . $layered[0] . '.php';
            $tmp = $config;

            //从1开始
            for ($i = 1, $count = count($layered); $i < $count; $i++) {
                $tmp = $tmp[$layered[$i]];
            }

            return $tmp;
        }
        //@todo 设置key值的段落
    }
}

if (!function_exists('app')) {
    /**
     *  ioc一些class
     * @param $class
     * @return mixed
     * @throws \Exception
     */
    function app($class): mixed
    {
        return App::make($class);
    }
}

if (!function_exists('getKeyByArray')) {
    /**
     *  array_search函数的变形，对二维数组中一个字段进行搜索。
     * todo 该函数遇到第一个匹配就会停止
     * @param          $needle
     * @param  array   $arr
     * @param  string  $key_of_search
     * @return mixed
     */
    function getKeyByArray(mixed $needle, array $arr, string $key_of_search): mixed
    {
        foreach ($arr as $key => $item) {
            $row = $item;

            if ($row[$key_of_search] === $needle) {
                return $key;
            }
        }

        return null;
    }
}

if (!function_exists('abort')) {
    function abort(int $code): never
    {
        http_response_code($code);
        echo $code;
        die;
    }
}