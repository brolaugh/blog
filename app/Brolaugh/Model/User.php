<?php
namespace Brolaugh\Model;

use \Brolaugh\Core\Database;
use \Brolaugh\Config;
use Brolaugh\Helper\Session;
use Brolaugh\Helper\Validator;

class User extends Visitor
{
  protected $id;
  public $username;
  private $password;
  private $email;
  private $cookie;

  public function __construct($visitor = false)
  {
    if ($visitor instanceof Visitor) {
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

  public function register()
  {
    $this->username = trim($_POST['register-username']);
    $this->email = trim($_POST['register-email']);

    $this->password = trim($_POST['register-password']);
    $passwordConfirm = trim($_POST['register-password-confirm']);

    $validator = new Validator();
    $validator->addRuleMessage('matches', '{field} must match password');
    $validator->validate([
        'register-username|Username' => [$this->username, 'required|min(3)|max(40)|validUsername|uniqueUsername'],
        'register-email|Email' => [$this->email, 'required|email|max(255)|uniqueEmail'],
        'register-password|Password' => [$this->password, 'required|min(8)'],
        'register-password-confirm|Password confirmation' => [$passwordConfirm, 'required|matches(register-password)'],
        'token' => [$this->token, 'required|validToken'],
        ]);

    if ($validator->fails()) {
      var_dumpi($validator->errors()->all());
      die();
    }else {
      $this->password = password_hash($this->password, PASSWORD_BCRYPT, Config::get('hashing'));
      $this->finishRegistration();
    }
  }

  public function login()
  {

    $this->email = trim($_POST['login-email']);
    $this->password = trim($_POST['login-password']);

    $validator = new Validator();
    $validator->validate([
      'login-email|Email' => [$this->email, 'required|email|max(255)'],
      'login-password|Password' => [$this->password, 'required|min(8)'],
    ]);
    if($validator->fails()){
      var_dumpi($validator->errors()->all());
      die();
    }

    $stmt = Database::prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param('s', $this->email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_object()) {
      if (password_verify($this->password, $row->password)) {
        Session::set(Config::get('session/session_name'), bin2hex(random_bytes(60)));
        echo "User {$this->email} logged in";
      } else {
        echo "Login failed";
      }


    } else
      echo "Login failed";

  }

  private function finishRegistration()
  {
    $stmt = Database::prepare("INSERT INTO user(email, username, password, joined, `group`) VALUES(?,?,?, NOW(), 1)");
    $stmt->bind_param('sss', $this->email, $this->username, $this->password);
    var_dumpi($stmt->execute());
  }

  public function isLoggedIn()
  {
    return isset($_SESSION[Config::get('session/session_name')]) ? "Session set<br/> value: " . $_SESSION[Config::get('session/session_name')] : false;
  }
}
