<?php

declare(strict_types=1);

namespace Bin\Route;

use Bin\App\App;
use Bin\Request\Request;
use Exception;

class RouteCollection /*implements \Iterator*/
{
    //使用单例模式
    private static $instance;
    private static array $route = [];
    private static array $method = [
        'get',
        'post',
    ];

    private static $routeIndex = null;

    public function __construct()
    {
        // if (self::$instance instanceof $this) {
        // return self::$instance;
        // }

    }

    //    public function current()
    //    {
    //
    //    }
    //
    //    public function next()
    //    {
    //
    //    }
    //
    //    public function key()
    //    {
    //
    //    }
    //
    //    public function valid()
    //    {
    //
    //    }
    //
    //    public function rewind()
    //    {
    //
    //    }

    /**
     *  获取匹配到的路由
     * @return \Bin\Route\Route|null
     * @throws \Exception
     */
    public static function getRoute(): ?Route
    {
        $path = getUrl();
        $method = getMethod();

        return self::match($method, $path);
    }

    /**
     * 匹配路由
     * @param  string  $method
     * @param  string  $path
     * @return \Bin\Route\Route|null
     * @throws \Exception
     * @static
     */
    private static function match(string $method, string $path): ?Route
    {
        foreach (self::$route as $route) {
            //if (false === self::$route instanceof self) {
            //    continue;
            //}

            if ($route->getMethod() == $method && $route->getPath() === $path) {
                return $route;
            }

            //判断是否存在preg
            if (null !== $route->getPreg()) {
                if ($route->withSuccess((App::make(Request::class)->getPath()))) {
                    return $route;
                }
            }
        }

        throw new \Exception('ROUTE NO MATCH', 1);
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
        //        $action = new Route(['method' => $method, 'path' => $path, 'action' => $action]);
        $action = new Route($method, $path, $action);
        array_push(self::$route, $action);

        return $action;
    }

    /**
     *  处理middle
     * @param  array     $param
     * @param  \Closure  $callback
     */
    public static function middle(array $param, \Closure $callback)
    {
        //先获取当前的路由个数，在获取之后的路由个数，然后给最后获取的路由处理一下
        $currentRouteCount = count(self::$route);
        //先获取本次的结果
        $callback();
        $nowRouteCount = count(self::$route);

        for ($i = $currentRouteCount; $i < $nowRouteCount; $i++) {
            self::$route[$i]->middle(['middle' => $param]);
        }
    }

    /**
     *  处理多个get的router
     * @param  array  $param
     */
    public static function getArray(array $param)
    {
        foreach ($param as $key => $item) {
            self::action('GET', $key, $item);
        }
    }

    public static function __callStatic($method, $param)
    {
        if (!in_array(strtolower($method), self::$method)) {
            throw new Exception('REQUEST METHOD NOT MATCH', 1);
        }

        //@todo 解析$param 。 这的param应该是array
        //@todo 大概是可以这么解析吧
        self::action($method, $param[0], $param[1]);
    }

    public static function get($path, $param)
    {
        return self::action('GET', $path, $param);
    }

    public static function post($path, $param)
    {
        return self::action('POST', $path, $param);
    }
}