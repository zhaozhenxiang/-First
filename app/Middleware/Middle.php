<?php

declare(strict_types=1);

namespace App\Middleware;

class Middle
{
    private $mapping = [
        'a' => A::class,
    ];

    /**
     *  获取name
     * @param $name
     * @return bool
     */
    public function getClass($name)
    {
        return $this->mapping[$name] ?? false;
    }
}