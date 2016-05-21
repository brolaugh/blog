<?php

/**
 * Created by PhpStorm.
 * User: hannes.kindstrommer
 * Date: 2016-05-17
 * Time: 14:41
 */
namespace models;
class Post extends \Database
{
    public $id;
    public $blog;
    public $title;
    public $content;
    public $status;
    public $create_time;
    public $publishing_time;
    public $tags;

    public function prepare($post){
        $data = $this->getPostByID($post);
        $this->id = $post;
        $this->blog = $data->blog;
        $this->title = $data->title;
        $this->content = $data->content;
        $this->status = $data->status;
        $this->create_time = $data->create_time;
        $this->publishing_time = $data->publishing_time;
        $this->tags = $this->getTagsFromPostID($this->id);

        $md = new \Parsedown();
        $this->content= $md->parse($this->content);
    }

}