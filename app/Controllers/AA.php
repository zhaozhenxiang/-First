<?php
namespace App\Controllers;
use \App\Model\User;

class AA extends BaseController
{
    use \Bin\Reflection\Reflect;

    public function BB()
    {
        return \Bin\View\View::make('index.php')->with('a', User::select('select * from test', 'data'));
    }

    public function rel()
    {
        $class = $this->getAbstractReflectionClass('\App\Controllers\BB');
        var_dump($class);
        var_dump($class->isInstantiable());
        var_dump($class->getConstructor());
        var_dump($class->getMethod('test'));
        var_dump($class->getMethod('test')->getParameters());
        var_dump($class->getMethod('test')->isPublic());
        var_dump($class->getMethod('test')->getModifiers());
        var_dump($class->getMethod('test')->getDeclaringClass());
    }

    public function postA()
    {
        return __FILE__ . json_encode($_POST);
    }

    public function middle()
    {
        return 'middle';
    }
}