<?php
class View
{
    const viewPath = BASH_PATH . '/public/views/';
    private static $targetView;
    private static $targetData = [];
    private static $instance;

    public function __construct()
    {

    }

    public static function make($path)
    {
        self::$targetView = self::viewPath . $path;

        return is_null(self::$instance) ? new self : self::$instance;
    }

    public function with($key, $value)
    {
        if (is_null(self::$targetView)) {
            throw new \Exception('WITH must after the MAKE', 1);
        }
        self::$targetData[$key] = $value;

        return $this;
    }

    public function getView()
    {
        return self::$targetView;
    }

    public function getData()
    {
        return self::$targetData;
    }
}