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
        try {
            extract($this->view->getData());
            include $this->view->getView();
        } catch (\Exception $e) {
            throw new \Exception('View Compiler Error', 1);
        }
    }
}