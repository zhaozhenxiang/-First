<?php
namespace Bin\Route;

class Route
{
    //使用单例模式
    private static $instance;
    private static $route = [];
    private static $method = [
        'get',
        'post'
    ];

    public function __construct()
    {
        // if (self::$instance instanceof $this) {
        // return self::$instance;
        // }

    }

    public static function getRoute()
    {
        $path = getUrl();
        $method = getMethod();

        return self::match($method, $path);
    }

    private function match($method, $path)
    {
        foreach (self::$route as $key => $value) {
            //需要index.php来控制rewrite
            if ($value['method'] == $method && ($value['path'] === $path || '/index.php' . $value['path'] === $path)) {
                return $value;
            }
        }

        throw new Exception("ROUTE NO MATCH", 1);
    }

    /*    public function getInstance()
        {
            if (self::$instance instanceof $this) {
                return self::$instance;
            }

            return new static;
        }*/


    private static function action($method, $path, $action)
    {
        array_push(self::$route, ['method' => $method, 'path' => $path, 'action' => $action]);
    }

    public static function __callStatic($method, $param)
    {
        if (!in_array(strtolower($method), self::$method)) {
            throw new Exception("REQUEST METHOD NOT MATCH", 1);
        }

        //@todo 解析$param 。 这的param应该是array
        //@todo 大概是可以这么解析吧
        self::action($method, $param[0], $param[1]);
    }

    public function get($path, $param)
    {
        self::action('GET', $path, $param);
    }

    public function post($path, $param)
    {
        self::action('POST', $path, $param);
    }
}