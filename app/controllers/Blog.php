<?php

class blog extends Controller
{
    private $blog;
    private $blogModel;
    private $authorModel;
    private $sideMenuItems = [];

    public function __construct($blog)
    {
        $this->blog = $blog;

        $this->blogModel = $this->model("Blog");
        $this->blogModel->prepare($this->blog);

        $this->authorModel = $this->model("Author");
        $this->authorModel->prepare($this->blogModel->author);
    }

    public function index($data = [])
    {
        if (count($data) == 1) {
            $this->post($data[0]);
        } else {
            $options = [];
            if ($data[0] == "page" && is_numeric($data[1])) {
                $options["offset"] = $data[1];
            }
            $posts = (new Database())->getPostsByBlog($this->blog, $options);
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
    public function post($post = [])
    {
        if (count($post) == 0) {
            header("Location: /" . $this->blogModel->name . "/");
        } else {

            $postModel = $this->model("Post");
            if (!$postModel->prepare($post[0], $this->blog)) {
                $this->Error404();
                exit();
            }

            /* Code below breaks $postModel
            foreach($this->model("Post")->getSideMenuItems($this->blog) as $sideMenuItem){
                $this->sideMenuItems[] = $sideMenuItem;
            }*/
            $this->view("blog/post", ["blog" => $this->blogModel, "post" => $postModel, "author" => $this->authorModel, "sideMenuItems" => $this->sideMenuItems]);
        }
    }

    public function compose($post = ["new"])
    {
        $postModel = $this->model("Post");
        $unPublishedPostModels = [];
        $options = [
            "limit" => "int.MaxValue",
            "offset" => 0,
            "status" => [1]
        ];
        switch ($post[0]) {
            case "send":
                $postModel->send($this->blog);
                header("Location:/" . $this->blogModel->name . "/post/" . $postModel->url_title);
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