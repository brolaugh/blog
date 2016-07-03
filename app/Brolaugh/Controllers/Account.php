<?php


namespace Brolaugh\Controllers;


use Brolaugh\Config;
use Brolaugh\Core\Controller;
use Brolaugh\Helper\Session;
use Brolaugh\Helper\Validator;


class Account extends Controller
{
  private $userModel;

  public function __construct()
  {
    parent::__construct();

    $this->userModel = $this->model("User", [
        $this->visitor
    ]);
  }

  public function index($args)
  {
    if ($this->userModel->isloggedIn())
      $this->home($args);
    else
      $this->login($args);


  }

  public function home($args)
  {
    if ($this->userModel->isLoggedIn())
      $this->view('account/home', [
          'user' => $this->userModel,
      ]);
    else
      $this->login($args);

  }

  public function login($args)
  {
    if ($this->userModel->isLoggedIn()) {
      header('Location:/account');
    }
    if ($args[0] == 'send') {
      if ($this->userModel->login()) {
        header('Location:/account');
      }
    } else
      $this->view("account/login", [
          'user' => $this->userModel
      ]);


  }

  public function logout()
  {
    if ($this->userModel->logout())
      header('Location:/account/login');
    else
      header('Location:/account/home');
  }

  public function register($args)
  {

    if ($this->userModel->isLoggedIn()) {
      header('Location:/account');
    }
    if ($args[0] == 'send') {
      if ($this->userModel->register()) {
        header('Location:/account/login');
      } else {
        header('Location:/account/register');
      }
    } else
      $this->view("account/register", [
          'user' => $this->userModel,
          'errors' => Session::getFlash('errors'),
      ]);

  }
}
