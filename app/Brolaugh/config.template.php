<?php
//Create a copy named config.php
namespace Brolaugh;
class Config{
  private static $config = array(
      'mysql' => [
          'host' => '',
          'username' => '',
          'password' => '',
          'db' => ''
      ],
      'remember' => [
          'cookie_name' => 'logged_in_cookie',
          'cookie_expiry' => 604800,

      ],
      'session' => [
          'session_name' => 'logged_in_session',
      ],
      'cookie_options' => [
          'expiry' => 604800,
          'domain' => 'localhost',
          'path' => '/',
          'secure' => false,
          'httponly' => true,
      ],
      'twig' => [
          'cache' => "../twigcache/",
          'debug' => true,
          'auto_reload' => true,
          'autoescape' => false,
      ],
      'hashing' => [
          'cost' => 10
      ]

  );
  public static function get($string){
    $seq = explode("/", $string);
    $con = self::$config;
    foreach ($seq as $bit){
      if(isset($con[$bit]))
        $con = $con[$bit];
    }

    return $con;
  }
}