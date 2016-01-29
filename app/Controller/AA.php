<?php
class AA
{
    public function BB()
    {
        include basePath() . '/bin/view/View.php';
        include_once basePath() . '/bin/model/Model.php';
        include_once basePath() . '/bin/model/User.php';

        return View::make('index.php')->with('a', User::select('select * from test', 'data'));
    }
}