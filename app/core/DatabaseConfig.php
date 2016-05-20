<?php

/**
 * Created by PhpStorm.
 * User: hannes.kindstrommer
 * Date: 2016-05-20
 * Time: 14:14
 */
class DatabaseConfig
{
    private $server = "";
    private $username = "";
    private $password = "";
    private $database = "";
    protected $database_connection;
    public function __construct()
    {
        $this->database_connection = new Mysqli($this->server, $this->username, $this->password, $this->database);
        if(!mysqli_connect_errno()){
            $this->database_connection->set_charset('utf-8');
        }
    }
}