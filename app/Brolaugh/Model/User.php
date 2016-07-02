<?php
namespace Brolaugh\Model;

use \Brolaugh\Core\Database;
use \Brolaugh\Config;
use Brolaugh\Helper\Token;

class User extends Visitor
{
  protected $id;
  public $username;
  private $password;
  private $email;
  private $cookie;

  public function __construct($visitor = false)
  {
    if($visitor instanceof Visitor){
      $this->token = $visitor->token;
    }

    $this->cookie = isset($_COOKIE[Config::get('remember/cookie_name')]) ? $_COOKIE[Config::get('remember/cookie_name')] : false;
  }

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
    if(Token::check(Config::get('session/session_name')))
      die("Token invalid");
    elseif($_POST['register-password'] != $_POST['register-password-confirm'])
      die("Non matching password");
    elseif (!$this->emailRegistered($_POST['register-email'])){
      die("Email already used");
    } else{
      $this->password = password_hash($_POST['register-password'], PASSWORD_BCRYPT,Config::get('hashing'));
      $this->email = $_POST['register-email'];
      $this->finishRegistration();
    }

  }
  public function login(){
    if(Token::check(Config::get('session/session_name')))
      die("Token invalid");


    $this->email = $_POST['login-email'];
    $stmt = Database::prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param('s', $this->email);
    $stmt->execute();
    $res = $stmt->get_result();
    if($row = $res->fetch_object()){
      if(password_verify($_POST['login-password'],$row->password)){
        $_SESSION[Config::get('session/session_name')] = bin2hex(random_bytes(60));
        echo "User {$this->email} logged in";
      }else{
        echo "Login failed";
      }


    }else
      echo "Login failed";

  }

  private function finishRegistration(){
    $stmt = Database::prepare("INSERT INTO user(email, username, password, joined, `group`) values(?,?,?, NOW(), 1)");
    $stmt->bind_param('sss', $this->email, $this->username, $this->password);
    var_dumpi($stmt->execute());
  }
  public function isLoggedIn(){
    return isset($_SESSION[Config::get('session/session_name')]) ?  "Session set<br/> value: ". $_SESSION[Config::get('session/session_name')] : false;
  }
  
  private static function emailRegistered($email){
    $stmt = Database::prepare("SELECT email FROM user WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    return (boolean) $stmt->affected_rows;
  }
}
