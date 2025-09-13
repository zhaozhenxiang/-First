<?php

declare(strict_types=1);

namespace App\Controllers;

use \Bin\Request\Request;

class BB
{
    public function __construct()
    {
        return [];
    }

    public function test($a)
    {

    }

    public function request(Request $a)
    {
        var_dump($a, $a->a, $a->all());
    }
}