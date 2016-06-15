<?php

require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/Database.php';
require_once '../lib/Parsedown.php';

function var_dumpi($arg){
    echo '<pre>';
    var_dump($arg);
    echo '</pre>';
}