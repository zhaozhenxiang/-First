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
            include_once  basePath() . '/app/Controller/' . $class . '.php';
        } catch(\Exception $e) {
            throw($e);
        }

        $instance = new $class;
        $response = $instance->$method();

        if ($response instanceof View) {
            include_once basePath() . '/bin/view/Compiler.php';
            $compiler = new Compiler($response);
            return $compiler->getPHP();
        } else {
            return $response;
        }
    }
 }