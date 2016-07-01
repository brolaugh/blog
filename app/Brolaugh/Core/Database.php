<?php

/*
* Mysql database class - only one connection allowed
*/
namespace Brolaugh\Core;

class Database
{
  private $_connection;
  private static $_instance; //The single instance

  /*
  Get an instance of the Database
  @return Instance
  */
  public static function getInstance()
  {
    if (!self::$_instance) { // If no instance then make one
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  // Constructor
  private function __construct()
  {
    $this->_connection = new \mysqli(
      $GLOBALS['config']['mysql']['host'],
        $GLOBALS['config']['mysql']['username'],
        $GLOBALS['config']['mysql']['password'],
        $GLOBALS['config']['mysql']['db']
    );
    if (!mysqli_connect_errno()) {
      $this->_connection->set_charset('UTF8');
    }

    // Error handling
    if (mysqli_connect_error()) {
      trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(),
          E_USER_ERROR);
    }
  }

  // Magic method clone is empty to prevent duplication of connection
  private function __clone()
  {
  }

  // Get mysqli connection
  public function getConnection()
  {
    return $this->_connection;
  }
  public static function prepare($sql){
    return self::getInstance()->getConnection()->prepare($sql);
  }


  public function blog_exists($blog)
  {
    $stmt = $this->getConnection()->prepare("SELECT id FROM blog WHERE name = ?");
    $stmt->bind_param('s', $blog);
    $stmt->execute();

    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
      $stmt->free_result();
      $stmt->close();
      return $res->fetch_object()->id;
    } else {
      $stmt->free_result();
      $stmt->close();
      return false;
    }
  }

  /**
   * @param $blog
   * @param array $options
   * @return array
   */
  public static function getPostsByBlog(
      $blog,
      $options = [
          "limit" => 5,
          "offset" => 0,
        //Var below is disabled
          "sort_order" => "DESC",
        //Var below is disabled
          "sort_column" => "publishing_time",
          "status" => [4]
      ]
  )
  {
    if (!isset($options['limit'])) {
      $options['limit'] = 5;
    }
    if (!isset($options['offset'])) {
      $options['offset'] = 0;
    }
    if (!isset($options['sort_order'])) {
      //Disabled
      $options['sort_order'] = "DESC";
    }
    if (!isset($options['sort_column'])) {
      //Disabled
      $options['sort_column'] = "publishing_time";
    }
    if (!isset($options['status'])) {
      $options['status'] = [4];
    }

    $questionMarks = "";
    $param = "i";
    $paramValues = [$blog];
    foreach ($options['status'] as $status) {
      if (strlen($questionMarks) == 0) {
        $param .= 'i';
        $paramValues[] = $status;
        $questionMarks .= "?";
      } else {
        $param .= 'i';
        $paramValues[] = $status;
        $questionMarks .= ",?";
      }
    }
    $param .= "ii";
    //Param should be "i" + "i" x count($options['status])+ "sii"
    array_unshift($paramValues, $param);
    $paramValues = array_merge($paramValues, [$options['limit'], $options['offset']]);
    $paramValues = array_values($paramValues);
    $query = "SELECT id FROM post WHERE blog = ? AND status IN(" . $questionMarks . ") ORDER BY publishing_time DESC LIMIT ? OFFSET ?";
    $stmt = self::prepare($query);
    call_user_func_array([$stmt, "bind_param"], makeValuesReferenced($paramValues));
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->free_result();
    $stmt->close();
    $retval = [];
    while ($row = $res->fetch_object()) {
      $retval[] = $row->id;
    }
    return $retval;


  }

  public static function getAllBlogs()
  {
    $stmt = self::prepare("SELECT id FROM blog");
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->free_result();
    $stmt->close();
    $retval = [];
    while ($row = $res->fetch_object()) {
      $retval[] = $row->id;
    }
    return $retval;
  }

}

function makeValuesReferenced($arr)
{
  $refs = array();
  foreach ($arr as $key => $value)
    $refs[$key] = &$arr[$key];
  return $refs;

}


?>