<?php
namespace Brolaugh\Model;

use \Brolaugh\Core\Database;

class User
{
  protected $id;
  public $username;
  private $password;
  private $email;
  private $lastCsrfRequest;

  public function prepare($id)
  {
    $stmt = Database::prepare("SELECT * FROM user WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0)
    $this->fillSelfWithData($res->fetch_object());
  }

  protected function fillSelfWithData($data)
  {
    $this->id = $data->id;
    $this->username = $data->username;
    $this->password = $data->password;
    $this->email = $data->email;
  }
  public function register(){
    $this->username = $_POST['register-username'];
    if($_POST['register-password'] != $_POST['register-password-confirm']){
      //Redirect back to register with non matching password error
    }elseif (!$this->emailRegistered($_POST['register-email'])){
      // Redirect back to register with email used error
    } else{
      $this->password = password_hash($_POST['register-password'], PASSWORD_BCRYPT, $GLOBALS['config']['hashing']);
      $this->email = $_POST['register-email'];
      $this->finishRegistration();
    }

  }
  public function login(){
    $this->email = $_POST['login-email'];
    $stmt = Database::prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param('s', $this->email);
    $stmt->execute();
    $res = $stmt->get_result();
    if($row = $res->fetch_object()){
      password_verify($_POST['login-password'],$row->password);
      echo "User {$this->email} logged in";
    }else
      echo "Login failed";

  }

  private function finishRegistration(){
    $stmt = Database::prepare("INSERT INTO user(email, username, password, joined, `group`) values(?,?,?, NOW(), 1)");
    $stmt->bind_param('sss', $this->email, $this->username, $this->password);
    var_dumpi($stmt->execute());
  }
  public function isLoggedIn(){
    if(isset($_SESSION[$GLOBALS['config']['session']['session_name']])){
      echo "Session set<br/> value: ", $_SESSION[$GLOBALS['config']['session']['session_name']];
      die();
    }
  }

  private static function emailRegistered($email){
    $stmt = Database::prepare("SELECT email FROM user WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    return (boolean) $stmt->affected_rows;
  }
}
