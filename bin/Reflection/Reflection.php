<?php

declare(strict_types=1);

namespace Bin\Reflection;

use Bin\App\App;
use Bin\Request\Request;

class Reflection
{
    use Reflect;

    /**
     *  得到class的method的param的参数的获取
     * @param $class
     * @param $method
     * @return array
     * @throws \Exception
     */
    public function getClassMethodParamInject($class, $method)
    {
        //反射的类,查看该文件是否存在
        $reClass = $this->getAbstractReflectionClass($class);

        return $this->getParameter($reClass->getMethod($method)->getParameters());
    }

    public function getCallBackParam(\Closure $f)
    {
        $ReflectionParameter = (new \ReflectionFunction($f))->getParameters();
        return $this->getParameter($ReflectionParameter);
    }

    /**
     *  处理反射的参数,每一个元素都是ReflectionParameter
     * @param  array  $param
     * @return array
     * @throws \Exception
     */
    private function getParameter(array $param)
    {
        //todo 没有处理class的构造函数的参数
        $order = [];
        $nullCount = 0;

        foreach ($param as $item) {
            //没有找到该参数的类型=>null，表示该函数的参数类型是php内置类型
            $tmp = $item->getClass();

            if (null === $tmp) {
                $nullCount ++;
                $order[] = null;
                $tmp[] = null;
                continue;
            }

            $order[] = $tmp->getName();
        }

        //拿到url中的数据
        $urlParam = App::make(Request::class)->getUrlParam();

        if ($nullCount > count($urlParam)) {
            throw new \Exception('param is not enough');
        }

        $param = [];
        $meetCount = 0;

        foreach ($order as $iValue) {

            if (null === $iValue) {
                $param[] = $urlParam[$meetCount];
                $meetCount ++;
            } else {
                $param[] = app($iValue);
            }
        }

        return $param;
    }
}