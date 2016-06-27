<?php

namespace models;


class Author extends User
{
    private $name;

    public function prepare($id)
    {
        $stmt = $this->database_connection->prepare("SELECT * FROM user WHERE id = ? LEFT JOIN author ON user.id=author.id");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows > 0)
            $this->fillSelfWithData($res->fetch_object());
    }
    public function fillSelfWithData($data)
    {
        parent::fillSelfWithData($data);
        $this->name = $data->name;
    }


}