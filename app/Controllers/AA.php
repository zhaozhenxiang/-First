<?php
namespace App\Controllers;
use \App\Model\User;

class AA extends BaseController
{
    public function BB()
    {
        return \Bin\View\View::make('index.php')->with('a', User::select('select * from test', 'data'));
    }
}