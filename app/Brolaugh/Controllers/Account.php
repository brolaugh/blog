<?php


namespace Brolaugh\Controllers;


use Brolaugh\Core\Controller;


class Account extends Controller
{
  private $userModel;

  public function __construct(){
    parent::__construct();

    $this->userModel = $this->model("User");
  }
  public function index($args){
    if(!$this->userModel->isloggedIn())
      $this->login($args);
     else{

    }
  }

  public function login($args){
    if($args[0] == 'send'){
      $this->userModel->login();
    } else
      $this->view("account/login", [
          'user' => $this->userModel
      ]);


  }
  public function register($args){
    if($args[0] == 'send'){
      $this->userModel->register();
    } else
      $this->view("account/register",
          ['user' => $this->userModel]
          );

  }
}
