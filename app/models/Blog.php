<?php

/**
 * Created by IntelliJ IDEA.
 * User: Brolaugh
 * Date: 2016-05-20
 * Time: 20:17
 */
namespace models;

class Blog extends \Database
{
    public $id;
    public $title;
    public $name;
    public $author;
    public $description;
    public $stylesheet;


    public function prepare($blog){
        $this->id = $blog;
        $data = $this->getBlogByID($blog);
        $this->title = $data->title;
        $this->name = $data->name;
        $this->author = $data->author;
        $this->description = $data->description;
    }
}