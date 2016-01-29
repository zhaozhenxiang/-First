<?php
$collection = ['a' => 'A', 'aa' => 'AA', 'b' => 'B', 'bb' => 'BB'];
$class = 'a';
//$search = array_search($class, array_keys($collection));
$search = array_search($class, $collection);
var_dump($search);
