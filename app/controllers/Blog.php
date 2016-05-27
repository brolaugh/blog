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

            $posts = (new Database())->getPostsByBlog($this->blog);
            $postModels = [];
            foreach($posts as $postID){
                $post = $this->model("Post");
                $post->prepare($postID, $this->blog);
                $postModels[] = $post;
            }
            $this->view("blog/index", ["blog" => $blogModel, "posts" => $postModels, "author" => $authorModel]);
        }
            
    }

    /**
     * @param $post name
     */
    public function post($post){
        $blogModel = $this->model("Blog");
        $blogModel->prepare($this->blog);
        
        $authorModel = $this->model("Author");
        $authorModel->prepare($blogModel->author);
        
        $postModel = $this->model("Post");
        $postModel->prepare($post, $this->blog);


        $this->view("blog/post", ["blog" => $blogModel, "post" => $postModel, "author" => $authorModel]);

    }
    public function compose($post = "new"){
        $blogModel = $this->model("Blog");
        $blogModel->prepare($this->blog);

        $authorModel = $this->model("Author");
        $authorModel->prepare($blogModel->author);

        $postModel = $this->model("Post");
        $unPublishedPostModels = [];
        $options = [
            "limit" => "int.MaxValue",
            "offset" => 0,
            "status" => [1]
        ];
        switch($post){
            case "send":
                $postModel->send($this->blog);
                header("Location:/$blogModel->name/post/$postModel->url_title");
                break;

            case "new":
                $unPublishedPostModels = (new Database())->getPostsByBlog($this->blog, $options);
                $postModel->loadStatusOptions();
                break;

            default:
                //get $post from database and fill forms
                $unPublishedPostModels = (new Database())->getPostsByBlog($this->blog, $options);
                $postModel->loadStatusOptions();
                $postModel->prepare($post, $this->blog);
                break;

        }
        $this->view("blog/compose", ["blog" => $blogModel, "post" => $postModel, "author" => $authorModel, "unpublishedPosts" => $unPublishedPostModels]);
    }
}