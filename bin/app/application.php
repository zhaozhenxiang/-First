 <?php
 //好像没有什么作用
 class App
 {
    //使用单例模式
    private static $instance;


    public function __construct()
    {
        if (self::$instance instanceof $this) {
            return self::$instance;
        }



    }

    public function getInstance()
    {
        if (self::$instance instanceof $this) {
            return self::$instance;
        }
    }


    // private function 
 }