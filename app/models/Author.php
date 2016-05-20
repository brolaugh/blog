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
}