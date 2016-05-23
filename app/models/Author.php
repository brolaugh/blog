<?php
/**
 * Created by IntelliJ IDEA.
 * User: Brolaugh
 * Date: 2016-05-20
 * Time: 21:58
 */

namespace models;


class Author extends \Database
{
    public $id;
    public $var;
    
    public function prepare($authorID){
        $this->id = $authorID;
        $this->var = $this->getVariblesByAuthorID($this->id);
    }

    private function getVariblesByAuthorID($authorID){
        $stmt = $this->database_connection->prepare("SELECT * FROM author_variables WHERE author = ?");
        $stmt->bind_param("i", $authorID);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->free_result();
        $stmt->close();
        $retval = [];
        while($row = $res->fetch_object()){
            $retval[]= $row;
        }
        return $retval;
    }
}