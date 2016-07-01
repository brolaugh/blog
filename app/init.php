<?php
use Brolaugh\Core\App;

function var_dumpi($arg)
{
  echo '<pre>';
  var_dump($arg);
  echo '</pre>';
}

require '../app/config.php';
define('INC_ROOT', dirname(__DIR__));
require INC_ROOT . '/vendor/autoload.php';
\php_error\reportErrors();

$app = new App;

?>
