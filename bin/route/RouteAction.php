<?php
namespace Bin\Route;

use Bin\Response\Response;
use \Bin\Reflection\Reflection;
class RouteAction
{
    public function __construct()
    {

    }

    public static function action()
    {
        $actionAy = RouteCollection::getRoute();

        //先处理middle
        if (FALSE == is_null($actionAy->getMiddle())) {
            $param = $actionAy->getMiddle();
            if (1 != count($param)) {
                throw new \Exception('middle param count must one');
            }
            //查看是否存在
            $class = (new \App\Middleware\Middle())->getClass(array_keys($param['middle'])[0]);
            if (FALSE == $class){
                throw new \Exception('middleware miss');
            }
            //key为middleware名字，value为middleware参数
            $handleResult = (new $class)->run(array_shift($param));

            if (TRUE !== $handleResult) {
                return new \Bin\Response\Response($handleResult);
            }
        }

        //处理闭包
        if (is_callable($actionAy->getAction())) {
            return self::doCallBack($actionAy->getAction());
        }
        //处理常规
        if (is_string($actionAy->getAction())) {
            list($class, $method) = explode('@', $actionAy->getAction());
            return self::doClassMethod($class, $method);
        }


        throw new Exception("404", 1);
    }

    private static function doCallBack(callable $action)
    {
        // return call_user_func($action);
        return $action();
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
    private static function doClassMethod($class, $method)
    {
        $re = app(Reflection::class);
        $class = '\App\Controllers\\' . $class;

        //反射的类,查看该文件是否存在
        $reClass = $re->getAbstractReflectionClass($class);
        //todo 没有处理class的构造函数的参数
        $order = [];
        foreach ($reClass->getMethod($method)->getParameters() as $key => $item) {
            //没有找到该参数的类型=>null，表示该函数的参数类型是php内置类型
            $tmp = $item->getClass();
            if (is_null($tmp)) {
                $tmp[] = NULL;
                continue;
            }

            $order[] = app($tmp->getName());
        }

        echo new Response(call_user_func_array(array(new $class, $method), $order));
    }
}