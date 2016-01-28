 <?php
 class RouteAction
 {
    public function __construct()
    {

    }

    public static function action()
    {
        $actionAy = Route::getRoute();

        if (is_callable($actionAy['action'])) {
            return self::doCallBack($actionAy['action']);
        } elseif (is_string($actionAy['action'])) {
            list($class, $method) = explode('@', $actionAy['action']);
            return self::doClassMethod($class, $method);
        }

        throw new Exception("404", 1);
    }

    private function doCallBack(callable $action)
    {
        // return call_user_func($action);
        return $action();
    }

    //@todo 这里应该使用反射
    private function doClassMethod($class, $method)
    {
        try {
            include_once  BASH_PATH . '/app/Controller/' . $class . '.php';
        } catch(\Exception $e) {
            throw($e);
        }
        $instance = new $class;
        return $instance->$method();
    }
 }