<?php
//Create a copy named config.php
$GLOBALS['config'] = array(
  'mysql' => [
    'host' => '',
    'username' => '',
    'password' => '',
    'db' => ''
  ],
  'remember' => [
    'cookie_name' => 'hash',
    'cookie_expiry' => 604800,

  ],
    'session' => [
      'session_name' => 'user',
    ],
    'twig' => [
        'cache' => "../twigcache/",
        'debug' => true,
        'auto_reload' => true,
        'autoescape' => false,
    ]

);