<?php
namespace Bin\Reflection;

trait Reflect
{
    //全部被反射的类的key value
    private static $class = [];
    public function getDoc($class, $method)
    {

    }

    public function getMethodParam($class, $method)
    {

    }

    public function call($class, $method)
    {

    }

    /**
     * @power 根据class得到反射类
     * @param $class
     * @return null|\ReflectionClass
     */
    private function getAbstractReflectionClass($class)
    {
        //@todo 先在self::$class里面查找
        $keys = array_keys(self::$class);
        $search = array_search($class, $keys);

        if (FALSE !== $search) {
            return self::$class[$keys[$search]];
        } else {
            unset($keys);
            unset($search);
        }

        //使用try
        try {
            $reflection = new \ReflectionClass($class);
        } catch(\Exception $e) {
            return NULL;
        }

        return $reflection;
    }

    private function getMethodParamType(\ReflectionFunctionAbstract $abstract, $method)
    {
        //获取被反射函数的数据类型
    }

    private function getMethodParamMatch(array $paramType)
    {
        //根据函数参数来尽量配置参数
    }
}