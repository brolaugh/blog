<?php

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
        $this->database_connection->query("SET NAMES 'utf8'");
        if (!mysqli_connect_errno()) {
            $this->database_connection->set_charset('utf-8');
        }

    }
}