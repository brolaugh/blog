<?php


namespace Brolaugh\Helper;


use Brolaugh\Config;

class Token
{

  public static function generate(){
    return Session::set(Config::get('session/token_name'), bin2hex(random_bytes(60)));
  }

  public static function check($token){
    $tokenName = Config::get('session/token_name');
    if(Session::exists($tokenName) && $token == Session::get($tokenName)){
      Session::delete($tokenName);
      return true;
    }else
      return false;

  }
}