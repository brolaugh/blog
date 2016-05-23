<?php

class blog extends Controller
{
    private $blog;

    public function __construct($blog){
        $this->blog = $blog;
    }

    public function index($post = ''){
        if(strlen($post) > 0)
            $this->post($post);
        else{
            $blogModel = $this->model("Blog");
            $blogModel->prepare($this->blog);

            $authorModel = $this->model("Author");
            $authorModel->prepare($blogModel->author);

            $db = new Database();

            $posts = $db->getPostsByBlog($this->blog);
            $postModels = [];
            foreach($posts as $postID){
                $post = $this->model("Post");
                $post->prepare($postID);
                $postModels[] = $post;
            }
            $this->view("blog/index", ["blog" => $blogModel, "posts" => $postModels, "author" => $authorModel]);
        }
            
    }
    public function post($post){
        echo 'post/' . $post;
    }
    public function compose($post = "new"){
        $blogModel = $this->model("Blog");
        $blogModel->prepare($this->blog);

        $authorModel = $this->model("Author");
        $authorModel->prepare($blogModel->author);

        $postModel = $this->model("Post");
        switch($post){
            case "send":
                $postModel->send($this->blog);
                break;

            case "new":
                break;

            default:
                //get $post from database and fill forms
                $postModel->prepare($post);
                break;

        }
        $this->view("blog/compose", ["blog" => $blogModel, "post" => $postModel, "author" => $authorModel]);
    }
}