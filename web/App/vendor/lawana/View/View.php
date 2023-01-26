<?php

namespace Lawana\View;

class View
{

    private $view;
    private $data;

    public function __construct($view, $data = [])
    {
        $this->view = $view;
        $this->data = $data;
    }

    public function getView()
    {
        return $this->view;
    }

    public function getData()
    {
        return $this->data;
    }

    public function part($view)
    {
        if ($check = self::check($view)) {
            $view = $this;
            $data = $this->getData();
            require_once $check[1];
        }
    }

    public static function check($view)
    {
        $view = str_replace('.php', '', $view);
        $view = str_replace('.', '/', $view);
        $view .= '.php';
        $pathView = PATH_APP . 'App/Views/';
        $file_view = $pathView . $view;
        if (file_exists($file_view)) {
            return [true, $file_view];
        } else {
            return false;
        }
    }
}
