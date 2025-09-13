<?php

declare(strict_types=1);

namespace Bin\View;

class Compiler
{
    private $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public function getPHP():string
    {
        try {
            extract($this->view->getData());

            require_once $this->view->getView();
        } catch (\Exception $e) {
            throw new \Exception('View Compiler Error', 1);
        }

        return '';
    }
}