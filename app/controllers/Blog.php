<?php

class blog extends Controller
{
    private $blog;
    private $blogModel;
    private $authorModel;

    public function __construct($blog)
    {
        $this->blog = $blog;

        $this->blogModel = $this->model("Blog");
        $this->blogModel->prepare($this->blog);

        $this->authorModel = $this->model("Author");
        $this->authorModel->prepare($this->blogModel->author);
    }

    public function index($post = '')
    {
        if (strlen($post) > 0)
            $this->post($post);
        else {
            $posts = (new Database())->getPostsByBlog($this->blog);
            $postModels = [];
            foreach ($posts as $postID) {
                $post = $this->model("Post");
                $post->prepare($postID, $this->blog);
                $postModels[] = $post;
            }
            $this->view("blog/index", ["blog" => $this->blogModel, "posts" => $postModels, "author" => $this->authorModel]);
        }

    }

    /**
     * @param $post name
     */
    public function post($post)
    {
        $postModel = $this->model("Post");
        $postModel->prepare($post, $this->blog);


        $this->view("blog/post", ["blog" => $this->blogModel, "post" => $postModel, "author" => $this->authorModel]);

    }

    public function compose($post = "new")
    {
        $postModel = $this->model("Post");
        $unPublishedPostModels = [];
        $options = [
            "limit" => "int.MaxValue",
            "offset" => 0,
            "status" => [1]
        ];
        switch ($post) {
            case "send":
                $postModel->send($this->blog);
                header("Location:/$this->blogModel->name/post/$postModel->url_title");
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
        $this->view("blog/compose", ["blog" => $this->blogModel, "post" => $postModel, "author" => $this->authorModel, "unpublishedPosts" => $unPublishedPostModels]);
    }
}