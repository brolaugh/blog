<?php


namespace Brolaugh\Model;


use Brolaugh\Helper\Token;

class Visitor
{
  public $token;

  public function __construct()
  {
    $this->token = Token::generate();
  }

}