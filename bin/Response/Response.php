<?php

namespace Bin\Response;

class Response
{
    //设置数据
    private $originContent = '';

    /**
     * @todo 之后要把该函数的实现改成工厂模式
     * @param $response
     * @throws \Exception
     */
    public function __construct($response)
    {
        //根据response类型来获取数据
        if (is_string($response)) {
            return $this->originContent = $response;
        }

        if (is_array($response)) {
            return $this->originContent = json_encode($response, 1);
        }

        //todo 处理编译view的问题
        if ($response instanceof \Bin\View\View) {
            return $this->originContent = (new \Bin\View\Compiler($response))->getPHP();
        }

        //todo 处理active record
    }

    /**
     * @power 获取content
     * @return string
     */
    public function getContent()
    {
        return $this->originContent;
    }

    /**
     * @power 设置content
     * @param $string
     * @return mixed
     */
    public function setContent($string)
    {
        return $this->originContent = $string;
    }

    /**
     * @power 获取数据
     * @return string
     */
    public function __tostring()
    {
        return $this->getContent();
    }
}