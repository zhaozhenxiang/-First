<?php

declare(strict_types=1);

namespace Bin\Route;

use App\Middleware\Middle;
use Bin\Response\Response;
use \Bin\Reflection\Reflection;
use Exception;

class RouteAction
{
    public function __construct()
    {

    }

    /**
     * 执行
     * @return \Bin\Response\Response|mixed|void
     * @throws \Exception
     * @static
     */
    public static function action()
    {
        $route = RouteCollection::getRoute();

        if (null === $route) {
            abort(404);
        }

        //先处理middle
        if (null !== $route->getMiddle()) {
            $param = $route->getMiddle();

            if (1 !== count($param)) {
                throw new \Exception('middle param count must one');
            }
            //查看是否存在
            $class = (new Middle())->getClass(array_keys($param['middle'])[0]);
            if (false == $class) {
                throw new \Exception('middleware miss');
            }
            //key为middleware名字，value为middleware参数
            $handleResult = (new $class)->run(array_shift($param));

            if (true !== $handleResult) {
                return new Response($handleResult);
            }
        }

        if (is_callable($route->getAction())) {
            return self::doCallBack($route->getAction());
        }

        if (is_string($route->getAction())) {
            [$class, $method] = explode('@', $route->getAction());
            return self::doClassMethod($class, $method);
        }

        abort(404);
    }

    private static function doCallBack(callable $action)
    {

        return call_user_func_array($action, app(Reflection::class)->getCallBackParam($action));
        return $action(app('Request')->getUrlParam()[0]);
//        return $action();
    }

    //@todo 这里应该使用反射
//    private static function doClassMethod($class, $method)
//    {
//        $class = '\App\Controllers\\' . $class;
//        //todo 反射class的构造函数的参数
//        $instance = new $class;
//        //todo 反射method函数的参数
//        $response = $instance->$method();
//        echo new Response($response);
//    }
//
    /**
     * 执行控制器方法
     * @param  string  $class
     * @param  string  $method
     * @return \Bin\Response\Response
     * @throws \Exception
     * @static
     */
    private static function doClassMethod(string $class, string $method): Response
    {
        $class = '\App\Controllers\\' . $class;

        return new Response(call_user_func_array([new $class, $method], app(Reflection::class)->getClassMethodParamInject($class, $method)));
    }
}