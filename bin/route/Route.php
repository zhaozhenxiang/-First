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

    /**
     * @power 获取匹配到的路由
     * @return mixed
     * @throws \Exception
     */
    public static function getRoute()
    {
        $path = getUrl();
        $method = getMethod();

        return self::match($method, $path);
    }

    private static function match($method, $path)
    {
        foreach (self::$route as $key => $value) {
            //需要index.php来控制rewrite
            if ($value['method'] == $method && ($value['path'] === $path || '/index.php' . $value['path'] === $path)) {
                return $value;
            }
        }

        throw new \Exception("ROUTE NO MATCH", 1);
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

    //todo 处理middle
    public static function middle(array $param, \Closure $callback)
    {
        /*        if (1 != count($param)) {
                    throw new \Exception('middle param count must one');
                }
                //查看是否存在
                $class = (new \App\Middleware\Middle())->getClass(array_keys($param)[0]);

                if (FALSE == $class){
                    throw new \Exception('middleware miss');
                }
                //key为middleware名字，value为middleware参数
                $handleResult = (new $class)->run(array_shift($param));
                if (TRUE == $handleResult) {
                    return $callback();
                }

                return new \Bin\Response\Response($handleResult);*/

        //先获取当前的路由个数，在获取之后的路由个数，然后给最后获取的路由处理一下
        $currentRouteCount = count(self::$route);
        //先获取本次的结果
        $callback();
        $nowRouteCount = count(self::$route);

        for ($i = $nowRouteCount - $currentRouteCount - 1; $i < $nowRouteCount; $i++) {
            self::$route[$i]['middle'] = $param;
        }
    }

    //todo 处理多个get的router
    public static function getArray(array $param)
    {
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

    public static function get($path, $param)
    {
        self::action('GET', $path, $param);
    }

    public static function post($path, $param)
    {
        self::action('POST', $path, $param);
    }
}