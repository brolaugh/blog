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

    public function prepare($post){
        $data = $this->getPostByID($post);
        $this->id = $post;
        $this->blog = $data->blog;
        $this->title = $data->title;
        $this->url_title = $data->url_title;
        $this->content = $data->content;
        $this->status = $data->status;
        $this->create_time = $data->create_time;
        $this->publishing_time = $data->publishing_time;
        $this->tags = $this->getTagsFromPostID($this->id);

        $md = new \Parsedown();
        $this->content= $md->parse($this->content);
    }
    public function send($blog){
        $this->blog = $blog;
        $this->title = $_POST['compose-title'];
        $this->content = $_POST['compose-body'];
        $this->status = 4;
        $this->tags = explode(",", $_POST['compose-tags']);
        $this->sendPost($this);
    }
    public function loadStatusOptions(){
        $stmt = $this->database_connection->prepare("SHOW COLUMNS FROM `post` LIKE 'status'");
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->free_result();
        $stmt->close();

        preg_match('/enum\((.*)\)$/', $res->fetch_object()->Type, $matches);
        $retval = explode(',', $matches[1]);
        for($i = 0; $i < count($retval); $i++){
            $retval[$i] = trim($retval[$i], "'");
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

    private function sendPost($blog){
        $stmt = $this->database_connection->prepare("INSERT INTO post(blog, title, content, status, create_time, publishing_time) values(?,?,?,?, NOW(), NOW())");
        $stmt->bind_param('issi', $blog->blog, $blog->title, $blog->content, $blog->status);
        $retval = $stmt->execute();
        $stmt->free_result();
        $stmt->close();
        return $retval;
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