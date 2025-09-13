<?php

declare(strict_types=1);

namespace Bin\Facade;

abstract class Facade
{
    private static $instance = [];
    //返回class名字
    abstract protected function getClassName();

    public static function __callStatic($method, $args)
    {
        if (!isset(self::$instance[static::class])) {
            $chindClass = (new static)->getClassName();
            self::$instance[static::class] = app($chindClass);
        }

        $instance = self::$instance[static::class];
        switch (count($args)) {
            case 0:
                return $instance->$method();
            case 1:
                return $instance->$method($args[0]);
            case 2:
                return $instance->$method($args[0], $args[1]);
            case 3:
                return $instance->$method($args[0], $args[1], $args[2]);
            case 4:
                return $instance->$method($args[0], $args[1], $args[2], $args[3]);
            default:
                return call_user_func_array([$instance, $method], $args);
        }
    }
}