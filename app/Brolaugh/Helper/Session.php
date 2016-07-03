<?php


namespace Brolaugh\Helper;


class Session
{
  public static function exists($name){
    return isset($_SESSION[$name]);
  }

  public static function set($name, $value){
    return $_SESSION[$name] = $value;
  }

  public static function get($name){
    return $_SESSION[$name];
  }

  public static function delete($name){
    if(self::exists($name)){
      unset($_SESSION[$name]);
    }
  }
  public static function getflash($name)
  {
    if (self::exists($name)) {
      $retval = self::get($name);
      self::delete($name);
      return $retval;
    }
  }
  public static function setFlash($name, $value = []){
    self::set($name, $value);
  }

}