<?php
if (!function_exists('getUrl')) {
    function getUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }
}

if (!function_exists('getMethod')) {
    function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}

