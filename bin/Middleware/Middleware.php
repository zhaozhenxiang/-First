<?php

declare(strict_types=1);

namespace Bin\Middleware;

abstract class Middleware
{

    /**
     *  获取上下文
     */
    protected function getContext()
    {
        return;
    }

    /**
     * 该函数函数返回true该可以继续
     * @return mixed|bool
     */
    abstract protected function handle(array $param);

    /**
     *  调用入口
     * @return mixed
     */
    public function run(array $param)
    {

        return $assert = $this->handle($param);

        //todo 处理handle的返回值
        if (true ===  $assert) {

        }
    }
}