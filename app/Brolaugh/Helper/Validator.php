<?php


namespace Brolaugh\Helper;


use Brolaugh\Core\Database;
use Violin\Violin;

class Validator extends Violin
{
  public function __construct()
  {
    $this->addRuleMessage('uniqueUsername', 'That {field} is already taken as a username');
    $this->addRuleMessage('validUsername', 'Usernames may include letters, digits and -_.');
    $this->addRuleMessage('uniqueEmail', '{field} is already in use as an email');
    $this->addRuleMessage('validToken', 'The form token was not valid, please try again');
  }

  public function validate_validUsername($value, $input, $args)
  {
    return preg_match('([A-Za-z0-9-_.])', $value);
  }

  public function validate_uniqueUsername($value, $input, $args)
  {
    $stmt = Database::prepare("SELECT count(username) AS username_count FROM user WHERE username = ?");
    $stmt->bind_param('s', $value);
    $stmt->execute();
    return !(boolean)$stmt->get_result()->fetch_row()[0];
  }

  public function validate_uniqueEmail($value, $input, $args)
  {
    $stmt = Database::prepare("SELECT count(*) AS email_count FROM user WHERE email = ?");
    $stmt->bind_param('s', $value);
    $stmt->execute();
    return !(boolean)$stmt->get_result()->fetch_row()[0];
  }

  public function validate_validToken($value, $input, $args)
  {
    return Token::check($value);
  }
}