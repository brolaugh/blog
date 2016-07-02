<?php


namespace Brolaugh\ViewModel;


class Visitor
{
  public $token;

  public function __construct($visitor)
  {
    $this->token = $visitor->token;
  }
}