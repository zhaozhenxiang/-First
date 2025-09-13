<?php

declare(strict_types=1);

namespace Bin\Facade;

class Request extends Facade
{
    protected function getClassName(): string
    {
        return \Bin\Request\Request::class;
    }
}