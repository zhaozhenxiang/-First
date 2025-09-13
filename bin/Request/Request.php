<?php

declare(strict_types=1);

namespace Bin\Request;

/**
 *  显示请求头的封装
 * Class Request
 * @package Bin\Request
 */
class Request implements \ArrayAccess, \Iterator
{
    //数据存放属性
    protected array $data = [];
    //头信息存放属性
    protected array $header = [];
    //路径信息存放属性
    protected string $path = '';

    //初始化信息
    private array $urlMatch = [];

    public function __construct()
    {
        foreach ($_REQUEST as $key => $item) {
            $this->$key = $item;
        }
    }

    /**
     * 获取头信息
     * @return array
     */
    public function getHeader(): array
    {
        return $_SERVER;
    }

    /*
     * 获取请求路径
     * @return string
     */
    public function getPath(): string
    {
        return trim($_SERVER['PATH_INFO'], '/');
    }

    /**
     * 请求开始时间
     * @param  string  $format
     * @return string
     */
    public function getStartTime(string $format = 'Y-m-d H:i:s'): string
    {
        return date($format, START_TIME);
    }

    /**
     * 获取请求类型
     * @return string
     */
    public function getRequestType(): string
    {
        return trim($_SERVER['REQUEST_METHOD'], '/');
    }

    /**
     * 获取请求全部信息
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * 获取指定字段数据
     * @param $field
     * @return mixed
     */
    public function getField($field): mixed
    {
        return $this->data[$field];
    }


    /**
     *
     * @param  array  $v
     * @return $this
     */
    public function setUrlParam(array $v): self
    {
        $this->urlMatch = $v;
        return $this;
    }

    /**
     * 请求参数
     * @return array
     */
    public function all(): array
    {
        return $this->data;
    }

    /**
     * 获取url
     * @return array
     */
    public function getUrlParam(): array
    {
        return $this->urlMatch;
    }

    public function &__get($key)
    {
        return $this->data[$key];
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function __isset($key)
    {
        return isset($this->data[$key]);
    }

    public function __unset($key)
    {
        unset($this->data[$key]);
    }

    public function offsetSet($offset, $value): void
    {
        if (null === $offset) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }


    public function offsetUnset($offset): void
    {
        if ($this->offsetExists($offset)) {
            unset($this->data[$offset]);
        }
    }

    public function offsetGet($offset): mixed
    {
        return $this->offsetExists($offset) ? $this->data[$offset] : null;
    }


    public function rewind(): void
    {
        reset($this->data);
    }

    public function current(): mixed
    {
        return current($this->data);
    }

    public function key(): mixed
    {
        return key($this->data);
    }

    public function next(): void
    {
        next($this->data);
    }

    public function valid(): bool
    {
        return null !== key($this->data);
    }
}