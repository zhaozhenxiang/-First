<?php

namespace Bin\Request;

/**
 * @power 显示请求头的封装
 * Class Request
 * @package Bin\Request
 */
class Request implements \ArrayAccess
{
    //数据存放属性
    protected $data = [];
    //头信息存放属性
    protected $header = [];
    //路径信息存放属性
    protected $path = NULL;

    //初始化信息
    public function __construct()
    {
    }

    //获取头信息
    public function getHeader()
    {
        return get_headers();
    }

    //获取请求路径
    public function getPath()
    {
        return $_SERVER['REQUEST_URI'];
    }

    //请求开始时间
    public function getStartTime($format = 'Y-m-d H:i:s')
    {
        return date($format, START_TIME);
    }

    //获取请求类型
    public function getRequestType()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    //获取请求全部信息
    public function getData()
    {
        return $this->data;
    }

    //获取指定字段数据
    public function getField($field)
    {
        return $this->data[$field];
    }

    public function offsetExists($offset)
    {

    }

    public function offsetGet($offset)
    {

    }

    public function offsetSet($offset, $value)
    {

    }

    public function offsetUnset($offset)
    {

    }

}