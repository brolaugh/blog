<?php

class Controller
{
    public static function model($model)
    {
        require_once '../app/models/' . $model . '.php';
        $model = "\\models\\" . $model;
        return new $model;
    }

    public static function view($view, $data = [])
    {
        require_once '../app/views/' . $view . '.php';
    }

    public function Error404($backLink = "")
    {
        if ($backLink == "") {
            $backLink = $_SERVER['HTTP_REFERER'];
        }
        $this->view("404", ["backlink" => $backLink]);

    }
}

