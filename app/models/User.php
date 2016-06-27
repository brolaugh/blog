<?php

namespace models;


class User extends \Database
{
    protected $id;
    private $username;
    private $password;
    private $email;

    public function prepare($id){
        $stmt = $this->database_connection->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows > 0)
            $this->fillSelfWithData($res->fetch_object());
    }
    protected function fillSelfWithData($data){
        $this->id = $data->id;
        $this->username = $data->username;
        $this->password = $data->password;
        $this->email = $data->email;
    }
}