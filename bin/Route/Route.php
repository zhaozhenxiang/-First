<?php

declare(strict_types=1);

namespace Bin\Route;

use Bin\App\App;
use Bin\Request\Request;

class Route
{
    private array $param = [];

    public function __construct($method, $path, $action)
    {
        // if (self::$instance instanceof $this) {
        // return self::$instance;
        // }
        $this->param = [
            'method' => $method,
            'path' => $path,
            'action' => $action,
        ];
    }

    /**
     *  合并数据
     * @param array $param
     */
    private function mergeParam(array $param)
    {
        $this->param = array_merge($this->param, $param);
    }

    /**
     *  为其中一项数据添加数据
     * @param array $param
     */
    private function addParam($key, $param)
    {
        if (!isset($this->param[$key])) {
            $this->param[$key] = [];
        }

        $this->param[$key][] = $param;
    }

    /**
     *  获取当前的url
     * @return mixed
     * @throws \Exception
     */
    public function getPath()
    {
        return $this->param['path'];
    }

    /**
     *  获取当前的METHOD
     * @return mixed
     * @throws \Exception
     */
    public function getMethod()
    {
        return $this->param['method'];
    }


    /**
     *  获取当前的action
     * @return mixed
     * @throws \Exception
     */
    public function getAction()
    {
        return $this->param['action'];
    }


    /**
     *  获取当前的middle
     * @return mixed
     * @throws \Exception
     */
    public function getMiddle()
    {
        return $this->param['middle'] ?? null;
    }

    /**
     *  判断url是否满足正则
     * @param $preg
     * @return \Bin\Route\Route
     */
    public function with($preg)
    {
        $this->addParam('preg', $preg);
        return $this;
    }

    /**
     *  设置middle
     * @param array $middle
     */
    public function middle(array $middle)
    {
        $this->mergeParam(['middle' => $middle]);
    }

    /**
     *  获取正则表达式
     * @return null|string
     */
    public function getPreg()
    {
        return $this->param['preg'] ?? null;
    }
    /**
     *  判断url是否满足正则
     *  $url string
     * @param $url
     * @return boolean
     * @throws \Exception
     */
//    public function withSuccess($url)
//    {
//        //匹配url
//        $prefixString = preg_replace('/\{.+\}/', '', $this->getPath());
////        $prefixStringAy = explode('/', $prefixString);
////        $prefixString = join('\/', $prefixStringAy);
//        $string = preg_replace($prefixString, '', $url);
//
//        var_dump($this->getPath(), $prefixString, $url, $string, 125);
//        if (1 > strlen($string)) {
//            return false;
//        }
//        if ('/' == $string[0]) {
//            $string = substr($string, 1, strlen($string) - 1);
//        }
//
//        //todo url 模式匹配
//        if (true == (preg_match('/^' . join('\/', $this->getPreg()) . '$/', $string, $out) > 0)) {
//            \Bin\App\App::make(\Bin\Request\Request::class)->setUrlParam(explode('/', $out[0]));
//            return true;
//        }
//
//        return false;
//    }

    public function withSuccess($url)
    {
        //匹配url
        $prefixString = preg_replace('/\{.+\}/', '', $this->getPath());
        $prefixStringAy = explode('/', $prefixString);
        //去掉掉一个空白元素
        '' == $prefixStringAy[0] && array_shift($prefixStringAy);
        $string = preg_replace('/' . join('\/', $prefixStringAy) . '[\/]?/', '', $url);

        if (1 > strlen($string)) {
            return false;
        }
        if ('/' == $string[0]) {
            $string = substr($string, 1, strlen($string) - 1);
        }

        //todo url 模式匹配
        if (true == (preg_match('/^' . join('\/', $this->getPreg()) . '$/', $string, $out) > 0)) {
            App::make(Request::class)->setUrlParam(explode('/', $out[0]));
            return true;
        }

        return false;
    }


}

