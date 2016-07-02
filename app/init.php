<?php
use Brolaugh\Config;
use Brolaugh\Core\App;

function var_dumpi($arg)
{
  echo '<pre>';
  var_dump($arg);
  echo '</pre>';
}

require_once '../app/Brolaugh/config.php';

session_set_cookie_params(
    time()+ Config::get('cookie_options/expiry'),
    Config::get('cookie_options/path'),
    Config::get('cookie_options/domain'),
    Config::get('cookie_options/secure'),
    Config::get('cookie_options/httponly')
);
session_cache_limiter(false);
session_start();


define('INC_ROOT', dirname(__DIR__));
require INC_ROOT . '/vendor/autoload.php';
\php_error\reportErrors();

$app = new App;

?>
