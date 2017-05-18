<?php
namespace Bin\App;

//好像没有什么作用
class App
{
    //使用单例模式
    private static $instance;
    //container
    private static $container = [];

    public function __construct()
    {
        if (self::$instance instanceof $this) {
            return self::$instance;
        }
    }

    public function getInstance()
    {
        if (self::$instance instanceof $this) {
            return self::$instance;
        }
    }


    /**
     * @power 将给定的class加载到static中
     * @param $class
     */
    public static function make($class)
    {
        //先判断是否已经加载了
        if (isset(self::$container[$class])) {
            return self::$container[$class];
        }

        return self::$container[$class] = self::loadClass($class);
    }

    /**
     * @power 加载一个类
     * todo 以后用到反射
     * @param $class
     * @return mixed
     */
    private static function loadClass($class)
    {
        return new $class;
    }
}