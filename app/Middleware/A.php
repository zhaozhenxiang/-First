<?php

declare(strict_types=1);

namespace App\Middleware;

use Bin\Middleware\Middleware;

class A extends Middleware
{
    protected function handle(array $param)
    {
//        return true;
        return '没有通过middle';
    }
}