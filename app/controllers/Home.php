<?php

/**
 * Created by PhpStorm.
 * User: hannes.kindstrommer
 * Date: 2016-05-17
 * Time: 13:20
 */
class Home extends Controller
{
    public function index($name = ''){
        echo 'home/index';
        $user = $this->model('User');
        $user->name = $name;
        $this->view('index', ['name' => $user->name]);
    }
}