<?php
namespace Bin\Route;

class Route
{
    private $param = [];

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
     * @power 合并数据
     * @param array $param
     */
    private function mergeParam(array $param)
    {
        $this->param = array_merge($this->param, $param);
    }

    /**
     * @power 为其中一项数据添加数据
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
     * @power 获取当前的url
     * @return mixed
     * @throws \Exception
     */
    public function getPath()
    {
        return $this->param['path'];
    }

    /**
     * @power 获取当前的METHOD
     * @return mixed
     * @throws \Exception
     */
    public function getMethod()
    {
        return $this->param['method'];
    }


    /**
     * @power 获取当前的action
     * @return mixed
     * @throws \Exception
     */
    public function getAction()
    {
        return $this->param['action'];
    }


    /**
     * @power 获取当前的middle
     * @return mixed
     * @throws \Exception
     */
    public function getMiddle()
    {
        return isset($this->param['middle']) ? $this->param['middle'] : NULL;
    }

    /**
     * @power 判断url是否满足正则
     * @param $preg
     * @return boolean
     */
    public function with($preg)
    {
        $this->addParam('preg', $preg);
        return $this;
    }

    /**
     * @power 设置middle
     * @param array $middle
     */
    public function middle(array $middle)
    {
        $this->mergeParam(['middle' => $middle]);
    }

    /**
     * @power 获取正则表达式
     * @return null|string
     */
    public function getPreg()
    {
        return isset($this->param['preg']) ? $this->param['preg'] : NULL;
    }
    /**
     * @power 判断url是否满足正则
     * @power $url string
     * @return boolean
     */
    public function withSuccess($url)
    {
        //从/a/11 => /a/{no}中获取match
/*        $matchString = preg_replace('/{.+}/', $this->getPreg(), $this->getPath());
        $matchString = quotemeta(ltrim($matchString, '/'));
        var_dump($matchString);
        $matchString = 'pick\/[0-9+]';
        return preg_match('/' . $matchString . '/', $url);*/

        //匹配url
        $prefixString = preg_replace('/\{.+\}/', '', $this->getPath());
        $string = preg_replace($prefixString, '', $url);
//        var_dump($prefixString, $url, $string);

        if (1 > strlen($string)) {
            return FALSE;
        }
        if ('/' == $string[0]) {
            $string = substr($string, 1, strlen($string) - 1);
        }
//        var_dump($string, $this->getPreg());
//        die;
//        var_dump($prefixString, $this->getPath(), $prefixString . join('/', $this->getPreg()),  $this->getPath());
//        die;

        //todo url 模式匹配
        //以及注入到闭包以及class的method的参数中
//        var_dump(join('\/', $this->getPreg()), $string);
//        die;
        if (TRUE == (preg_match('/^' . join('\/', $this->getPreg()) . '$/', $string, $out) > 0)) {
            \Bin\App\App::make(\Bin\Request\Request::class)['urlmatch'] = explode('/', $out[0]);
            return TRUE;
        }

        return FALSE;
    }


}

