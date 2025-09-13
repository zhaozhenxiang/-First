<?php

declare(strict_types=1);

namespace Bin\App;

//好像没有什么作用
use Bin\Facade\Request;
use Bin\Response\Response;
use Bin\Route\RouteCollection;

class App
{
    //使用单例模式
    private static self $instance;
    //container
    private static $container = [];

    //自定义ioc的key
    private static array $classMap = [
        'Request'  => \Bin\Request\Request::class,
        'Response' => Response::class,
        'Route'    => RouteCollection::class,
    ];

    private static array $facadeMap = [
        'Request' => Request::class,
    ];

    /**
     * 获取自身
     * @return self
     */
    public function getInstance(): self
    {
        if (self::$instance instanceof $this) {
            return self::$instance;
        }

        return self::$instance = new self;
    }

    //facade
    public static function facade($class)
    {
        //先判断是否已经加载了
        if (!isset(self::$facadeMap[$class])) {
            return;
        }

        if (is_file(BASE_PATH . DIRECTORY_SEPARATOR . self::$classMap[$class] . '.php')) {
            class_alias(self::$facadeMap[$class], $class);
            return self::$container[$class] = new $class;
        }

        return null;
    }

    /**
     * 将给定的class加载到static中
     * @param  string  $class
     * @return mixed
     * @throws \Exception
     */
    public static function make(string $class): mixed
    {
        //先判断是否已经加载了
        if (isset(self::$container[$class])) {
            return self::$container[$class];
        }

        $instance = self::loadClass($class);

        if (null !== $instance) {
            //查找是否有mapping
            $mapping = array_filter(self::$classMap, function ($v) use ($class) {
                return $class === $v;
            });

            //设置别名
            foreach ($mapping as $key => $val) {
                self::$container[$key] = $instance;
            }

            return self::$container[$class] = $instance;
        }

        throw new \Exception('make none');
    }

    /*    PRIVATE static function findClass($class)
        {
            //使用map
            //todo 这种信息是否应该放在composer中
            if (isset(self::$classMap[$class])) {
    //            require_once BASE_PATH . DIRECTORY_SEPARATOR . self::$classMap[$class] . '.php';
                return class_alias(self::$classMap[$class], $class, true, true);
            }

            is_file(BASE_PATH . DIRECTORY_SEPARATOR . $class) && require_once BASE_PATH . DIRECTORY_SEPARATOR . $class . '.php';

        }*/

    /**
     *  加载一个类
     * todo 以后用到反射
     * @param $class
     * @return mixed
     */
    private static function loadClass($class): mixed
    {
        $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        $classPath = lcfirst($classPath);

        if (is_file(BASE_PATH . DIRECTORY_SEPARATOR . $classPath . '.php')) {
            return new $class;
        }

        if (isset(self::$classMap[$class])) {
            $file = BASE_PATH . DIRECTORY_SEPARATOR . self::$classMap[$class] . '.php';

            if (is_file($file)) {
                require_once $file;
                self::$classMap[$class] = $class;
            }
        }

        return new self::$classMap[$class];
    }
}