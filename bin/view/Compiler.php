<?php

class Compiler
{
    private $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public function getPHP()
    {
        extract($this->view->getData());
        include $this->view->getView();
    }
}