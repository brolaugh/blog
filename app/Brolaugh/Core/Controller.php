<?php
namespace Brolaugh\Core;

class Controller
{
    public static function model($model)
    {
        $model = '\Brolaugh\Model\\' . $model;
        return new $model();
    }

    public static function view($view, $data = [])
    {
        require_once '../app/Brolaugh/views/' . $view . '.php';
    }

    public function Error404($backLink = "")
    {

        $this->view("404", ["backlink" => $backLink]);

    }
}

