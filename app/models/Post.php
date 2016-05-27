<?php

namespace models;
class Post extends \Database
{
    public $id;
    public $blog;
    public $title;
    public $url_title;
    public $content;
    public $status;
    public $create_time;
    public $publishing_time;
    public $tags;

    public $statusOptions;

    //Fetches data from the database based on the postID argument
    public function prepare($post, $blogID){
        $this->id = $post;
        if(is_numeric($post)){
            $this->insertData($this->getPostByID($post));
        }
        else if(is_string($post)){
            $this->insertData($this->getPostByURLTitle($post, $blogID));
        }
    }

    public function getPostByURLTitle($urlTitle, $blog){
        $stmt = $this->database_connection->prepare("SELECT * FROM post WHERE url_title = ? AND blog = ?");
        $stmt->bind_param("si", $urlTitle, $blog);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->free_result();
        $stmt->close();
        return $res->fetch_object();
    }
    //Collects data from the compose form and then sends it to the database
    public function send($blog){
        $this->blog = $blog;
        $this->title = $_POST['compose-title'];
        $this->url_title = str_replace(" ", "_", $_POST['compose-url-title']);
        $this->content = $_POST['compose-body'];
        $this->status = $_POST['compose-visibility'];
        $this->tags = explode(",", trim(",", $_POST['compose-tags']));
        foreach($this->tags as $key => $value){
            $this->tags[$key] = trim(",", $value);
        }
        if($this->doesURLTitleExistInBlog($this->url_title, $this->blog)){
            //Send client back to /blog/compose
            exit("That URL title already exists on this blog");
        }else{
            $this->sendPost($this);
        }
    }
    public function loadStatusOptions(){
        $stmt = $this->database_connection->prepare("SELECT * FROM post_status");
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->free_result();
        $stmt->close();
        $retval = [];
        while ($row = $res->fetch_object()){
            $retval[] = $row;
        }
        $this->statusOptions = $retval;
    }
    
    private function getPostByID($postID){
        $stmt = $this->database_connection->prepare("SELECT * FROM post WHERE id = ?");
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->free_result();
        $stmt->close();
        return $res->fetch_object();
    }
    private function insertData($data){
        $this->blog = $data->blog;
        $this->title = $data->title;
        $this->url_title = $data->url_title;
        $this->content = $data->content;
        $this->status = $data->status;
        $this->create_time = $data->create_time;
        $this->publishing_time = $data->publishing_time;
        $this->tags = $this->getTagsFromPostID($this->id);
        $this->content= (new \Parsedown())->parse($this->content);
    }
    //Sends the data to the database as a new row
    private function sendPost($blog){
        $stmt = $this->database_connection->prepare("INSERT INTO post(blog, title, url_title, content, status, create_time, publishing_time) values(?,?,?,?,?, NOW(), NOW())");
        $stmt->bind_param('isssi', $blog->blog, $blog->title, $blog->url_title, $blog->content, $blog->status);
        $retval = $stmt->execute();
        $stmt->free_result();
        $stmt->close();
        return $retval;
    }
    private function doesURLTitleExistInBlog($urlTitle, $blog){
        $stmt = $this->database_connection->prepare("SELECT id FROM post WHERE url_title = ? AND blog = ?");
        $stmt->prepare("si", $urlTitle, $blog);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->free_result();
        $stmt->close();
        return ($retval = $res->fetch_object()->id) ? $retval : false;
    }
    private function getTagsFromPostID($postID){
        $stmt = $this->database_connection->prepare("SELECT tag.name FROM post_tag LEFT JOIN tag ON post_tag.tag=tag.id WHERE post_tag.post = ?");
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->free_result();
        $stmt->close();
        $retval = [];
        while($row = $res->fetch_object()){
            $retval[] = $row->name;
        }
        return $retval;
    }
}